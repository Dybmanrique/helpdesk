<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IdentityType;
use App\Models\LegalPerson;
use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $request->validate([
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'second_last_name' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'digits:9'],
            'identity_number' => ['required', 'numeric'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'identity_type_id' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [], [
            'last_name' => 'apellido paterno',
            'second_last_name' => 'apellido materno',
        ]);
        
        $identity_type = IdentityType::find($request->identity_type_id);
        if ($identity_type->name === "Persona Jurídica") {
            $request->validate([
                'ruc' => ['required', 'numeric', 'digits:11'],
                'company_name' => ['required', 'string'],
            ], [], ['company_name' => 'razón social',]);
            $person = Person::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'second_last_name' => $request->second_last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'identity_number' => $request->identity_number,
                'identity_type_id' => $request->identity_type_id,
            ]);
            LegalPerson::create([
                'ruc' => $request->ruc,
                'company_name' => $request->company_name,
                'person_id' => $person->id,
            ]);
        } else {
            $person = Person::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'second_last_name' => $request->second_last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'identity_number' => $request->identity_number,
                'identity_type_id' => $request->identity_type_id,
            ]);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'person_id' => $person->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
