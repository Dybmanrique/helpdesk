<?php

namespace Database\Seeders;

use App\Models\IdentityType;
use App\Models\Person;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        IdentityType::create([
            'name' => 'DNI',
        ]);

        Person::create([
            'name' => 'Deyber Antonio',
            'last_name' => 'Manrique',
            'second_last_name' => 'Acuña',
            'phone' => '123456789',
            'address' => 'Calle 123',
            'identity_number' => '12345678',
            'identity_type_id' => 1,
        ]);

        // User::factory()->create([
        //     // 'name' => 'Test User',
        //     'email' => 'dbrmanrique@gmail.com',
            // 'person_id' => 1,
        // ]);

        IdentityType::create([
            'name'=>'Persona Natural',
        ]);
        IdentityType::create([
            'name'=>'Persona Jurídica',
        ]);
    }
}
