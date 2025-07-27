<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $identity_types = IdentityType::all();
        return view('auth.register', compact('identity_types'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
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
        ])->assignRole('Usuario Registrado');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('helpdesk.dashboard', absolute: false));
    }
}
