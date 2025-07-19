<?php

namespace App\Http\Requests;

use App\Models\IdentityType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $identityType = IdentityType::find($this->identity_type_id);
        [$min, $max] = match ($identityType?->name) {
            'DNI' => [8, 8],
            'Carnet Extranjería' => [9, 12],
            default => [8, 12],
        };
        return [
            'identity_type_id' => ['required', 'exists:identity_types,id'],
            'identity_number' => ['required', "between:$min,$max", 'regex:/^\d+$/'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'second_last_name' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'digits:9'],
            'address' => ['required', 'string'],
            'ruc' => ['nullable', Rule::requiredIf(!empty($this->company_name)), 'numeric', 'digits:11'],
            'company_name' => ['nullable', Rule::requiredIf(!empty($this->ruc)), 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'regex:/(.*)@(gmail\.com|outlook\.com|universidad\.edu\.pe)$/i', Rule::unique('users', 'email')->ignore($this->user()->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'identity_number.between' => match (IdentityType::find($this->identity_type_id)?->name) {
                'DNI' => 'El número de identificación debe tener 8 dígitos.',
                'Carnet Extranjería' => 'El número de identificación debe tener entre 9 y 12 dígitos.',
                default => 'El número de identificación puede tener hasta 12 dígitos.',
            },
            'email.regex' => 'El correo debe ser @gmail.com, @outlook.com o @universidad.edu.pe',
        ];
    }

    public function attributes(): array
    {
        return [
            'identity_type_id' => 'tipo de identificación',
            'identity_number' => 'número de identificación',
            'name' => 'nombre(s)',
            'last_name' => 'apellido paterno',
            'second_last_name' => 'apellido materno',
            'phone' => 'celular',
            'address' => 'dirección',
            'ruc' => 'RUC',
            'company_name' => 'razón social',
            'email' => 'correo electrónico',
        ];
    }
}
