<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdministrativeUser;
use App\Models\IdentityType;
use App\Models\Office;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdministrativeUsersController extends Controller
{
    public function index()
    {
        $identity_types = IdentityType::all();
        $offices = Office::all();
        return view('admin.administrative-users.index', compact('identity_types', 'offices'));
    }

    public function data()
    {
        $resolutions = AdministrativeUser::query()->with(['user.person.identity_type', 'office']);

        return DataTables::of($resolutions)
            ->addColumn('actions', function ($row) {
                return ''; // Las acciones se renderizan en el frontend
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'identity_type_id' => 'required|numeric',
            'identity_number' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'office_id' => 'required|numeric',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $person = Person::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'second_last_name' => $request->second_last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'identity_number' => $request->identity_number,
                'email' => $request->email,
                'identity_type_id' => $request->identity_type_id,
            ]);

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => 1,
                'person_id' => $person->id
            ]);

            AdministrativeUser::create([
                'user_id' => $user->id,
                'office_id' => $request->office_id,
                'is_default' => 0,
            ]);

            // Return success response with derivation status
            return response()->json([
                'message' => 'Hecho',
                'success' => true
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor',
                'success' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'administrative_user_id' => 'required|numeric',
            'identity_type_id' => 'required|numeric',
            'identity_number' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'office_id' => 'required|numeric',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($request->user_id),
            ],
        ]);

        if($request->password){
            $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        }

        try {
            $administrative_user = AdministrativeUser::findOrFail($request->administrative_user_id);

            $administrative_user->update([
                'office_id' => $request->office_id
            ]);

            $administrative_user->user->update([
                'email' => $request->email,
                'is_active' => 1,
            ]);

            $administrative_user->user->person->update([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'second_last_name' => $request->second_last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'identity_number' => $request->identity_number,
                'email' => $request->email,
                'identity_type_id' => $request->identity_type_id,
            ]);

            if($request->password){
                $administrative_user->user->update([
                    'password' => Hash::make($request->password)
                ]);
            }

            // Return success response with derivation status
            return response()->json([
                'message' => 'Hecho',
                'success' => true
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor',
                'success' => false
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $administrative_user = AdministrativeUser::findOrFail($id);

            // Eliminar al usuario
            $administrative_user->delete();

            //Si tiene trámites no eliminar al usuario, de lo contrario sí


            return response()->json([
                'message' => 'Eliminado correctamente',
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor',
                'success' => false,
            ]);
        }
    }
}
