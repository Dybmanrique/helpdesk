<?php

namespace App\Http\Controllers;

use App\Models\IdentityType;
use App\Models\LegalPerson;
use App\Models\LegalRepresentative;
use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Laravel\Socialite\Facades\Socialite;

class GoogleOAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            // Verificar si ya existe usuario con este external_auth_id y external_auth_provider
            $user = User::where('external_auth_id', $googleUser->getId())
                ->where('external_auth_provider', 'google')
                ->first();
            if ($user) {
                Auth::login($user);
                if (auth()->user()->isAdministrative()) {
                    return redirect()->intended(route('admin.dashboard', absolute: false));
                } else {
                    return redirect()->intended(route('helpdesk.dashboard', absolute: false));
                }
            }
            // Si no existe, verificar por email (usuario ya registrado manualmente)
            $user = User::where('email', $googleUser->getEmail())->first();
            if ($user) {
                // Actualizar el usuario para vincularlo con su cuenta de Google
                $user->update([
                    'external_auth_id' => $googleUser->getId(),
                    'external_auth_provider' => 'google',
                ]);
                Auth::login($user);
                if (auth()->user()->isAdministrative()) {
                    return redirect()->intended(route('admin.dashboard', absolute: false));
                } else {
                    return redirect()->intended(route('helpdesk.dashboard', absolute: false));
                }
            }

            // Guardar los datos necesarios en sesión y redirigir al formulario para completar el registro
            session([
                'google_user' => [
                    'provider' => 'google',
                    'id' => $googleUser->getId(),
                    'email' => $googleUser->getEmail(),
                    'name' => $googleUser->getName(),
                ],
                'google_oauth_pending' => true,
            ]);
            return redirect(route('complete_registration_form'));
        } catch (\Exception $e) {
            return redirect(route('auth.google'));
        }
    }

    public function create()
    {
        $identity_types = IdentityType::all();
        if (!session()->has('google_oauth_pending')) {
            return redirect(route('login'));
        }
        session()->forget('google_oauth_pending'); // para evitar que se ingrese al formulario indicando la ruta manualmente
        // Validar que haya datos en sesión
        if (!session()->has('google_user')) {
            return redirect(route('login'));
        } else {
            $googleUser = session('google_user');
            $email = $googleUser['email'];
            $userName = explode(' ', trim($googleUser['name']));
            if (count($userName) === 1) {
                $name = trim($userName[0]);
                $last_name = '';
                $second_last_name = '';
            } elseif (count($userName) === 2) {
                $name = trim($userName[0]);
                $last_name = trim($userName[1]);
                $second_last_name = '';
            } else {
                $fullUserName = collect($userName);
                $name = implode(' ', $fullUserName->shift(count($userName) - 2)->toArray());
                $last_name = $fullUserName->all()[0];
                $second_last_name = $fullUserName->all()[1];
            }
            return view('auth.complete-registration', compact('identity_types', 'email', 'name', 'last_name', 'second_last_name'));
        }
    }

    public function store(Request $request)
    {
        $identityType = IdentityType::find($request->identity_type_id);
        [$min, $max] = match ($identityType?->name) {
            'DNI' => [8, 8],
            'Carnet Extranjería' => [9, 12],
            default => [8, 12],
        };
        $request->validate([
            'identity_type_id' => ['required'],
            'identity_number' => ['required', "between:$min,$max", 'regex:/^\d+$/'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'second_last_name' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'digits:9'],
            'address' => ['required', 'string'],
            'ruc' => ['nullable', Rule::requiredIf(!empty($request->company_name)), 'numeric', 'digits:11'],
            'company_name' => ['nullable', Rule::requiredIf(!empty($request->ruc)), 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'regex:/(.*)@(gmail\.com|outlook\.com|universidad\.edu\.pe)$/i', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'identity_number.between' => match ($identityType?->name) {
                'DNI' => 'El número de identificación debe tener 8 dígitos.',
                'Carnet Extranjería' => 'El número de identificación debe tener entre 9 y 12 dígitos.',
                default => 'El número de identificación puede tener hasta 12 dígitos.',
            },
        ], [
            'identity_type_id' => 'tipo de identificación',
            'identity_number' => 'número de identificación',
            'name' => 'nombre(s)',
            'last_name' => 'apellido paterno',
            'second_last_name' => 'apellido materno',
            'phone' => 'celular',
            'company_name' => 'razón social',
        ]);

        try {
            $googleUser = session()->pull('google_user'); // obtener y borrar los datos de la cuenta de google de la session
            if (!$googleUser) {
                return response()->json([
                    'message' => 'Ocurrió un error en el servidor',
                    'success' => false
                ]);
            } else {
                $person = Person::firstOrCreate([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'second_last_name' => $request->second_last_name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'email' => $request->email,
                    'identity_number' => $request->identity_number,
                    'identity_type_id' => $request->identity_type_id,
                ]);
                if (!empty($request->ruc) && !empty($request->company_name)) {
                    $legalPerson = LegalPerson::updateOrCreate(
                        ['ruc' => $request->ruc],
                        ['company_name' => $request->company_name],
                    );
                    LegalRepresentative::firstOrCreate([
                        'person_id' => $person->id,
                        'legal_person_id' => $legalPerson->id,
                    ]);
                }
                $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'person_id' => $person->id,
                    'external_auth_id' => $googleUser['id'],
                    'external_auth_provider' => $googleUser['provider'],
                ])->assignRole('Usuario Registrado');

                event(new Registered($user));

                Auth::login($user);

                return response()->json([
                    'message' => 'Registro exitoso',
                    'redirect_to' => route('helpdesk.dashboard'),
                    'success' => true
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor',
                'success' => false
            ]);
        }
    }
}
