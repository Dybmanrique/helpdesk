<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\IdentityType;
use App\Models\LegalPerson;
use App\Models\LegalRepresentative;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $identityTypes = IdentityType::all();
        $person = $user->person;
        $legalRepresentative = LegalRepresentative::where('person_id', $person->id)->latest('updated_at')->first();
        $legalPerson = $legalRepresentative ? $legalRepresentative->legal_person : null;
        return view('profile.edit', compact('user', 'identityTypes', 'person', 'legalPerson'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated(); // obtengo los datos validados
        $user = $request->user();
        $person = $user->person;
        // el email solo se actualizará para la tabla usuarios, no para la tabla personas
        $person->update([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'second_last_name' => $validated['second_last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'identity_number' => $validated['identity_number'],
            'identity_type_id' => $validated['identity_type_id'],
        ]);
        if (!empty($validated['ruc']) && !empty($validated['company_name'])) {
            $legalPerson = LegalPerson::updateOrCreate(
                ['ruc' => $validated['ruc']],
                ['company_name' => $validated['company_name']],
            );
            // ya que al mostrar los datos se muestra el último registro actualizado, 
            // los datos de la tabla deben actualizarse o crearse, si no existen, para mostrar correctamente los datos
            $legalRepresentative = LegalRepresentative::where('person_id', $person->id)->where('legal_person_id', $legalPerson->id)->first();
            if ($legalRepresentative) {
                $legalRepresentative->updated_at = now();
                $legalRepresentative->save();
            } else {
                LegalRepresentative::create([
                    'person_id' => $person->id,
                    'legal_person_id' => $legalPerson->id,
                ]);
            }
        }
        $user->email = $validated['email'];
        $user->person_id = $person->id;
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Deactivate the user's account.
     */
    public function deactivate(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeactivation', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->update(['is_active' => 0]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
