<?php

namespace Database\Seeders;

use App\Models\AdministrativeUser;
use App\Models\Office;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HelpdeskUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //For helpdesk user
        $helpdesk_office = Office::create([
            'name' => 'Mesa de partes',
            'description' => 'Mesa de partes',
        ]);

        $person_deyber = Person::create([
            'name' => 'Deyber Antonio',
            'last_name' => 'Manrique',
            'second_last_name' => 'Acuña',
            'phone' => '123456789',
            'address' => 'Calle 123',
            'identity_number' => '88888888',
            'email' => 'dbrmanrique@gmail.com',
            'identity_type_id' => 1,
        ]);

        $user = User::create([
            'email' => 'dbrmanrique@gmail.com',
            'password' => Hash::make('password'),
            'is_active' => 1,
            'person_id' => $person_deyber->id,
        ]);

        AdministrativeUser::create([
            'user_id' => $user->id,
            'office_id' => $helpdesk_office->id,
            'is_default' => 1
        ]);
    }
}
