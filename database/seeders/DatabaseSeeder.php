<?php

namespace Database\Seeders;

use App\Models\AdministrativeUser;
use App\Models\IdentityType;
use App\Models\Office;
use App\Models\Person;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        IdentityType::create([
            'name' => 'RUC',
        ]);
        IdentityType::create([
            'name' => 'Carnet Extranjería',
        ]);

        // Ejemplo seeder usuario administrativo
        /***
        $office = Office::create([
            'name' => 'Administración',
            'description' => 'Oficina de administración',
        ]);

        $person = Person::create([
            'name' => 'Ever',
            'last_name' => 'Pachas',
            'second_last_name' => 'Romero',
            'phone' => '987654321',
            'address' => 'Ancash',
            'identity_number' => '1234567890',
            'identity_type_id' => 1,
        ]);

        $user = User::create([
            'email' => 'ever@gmail.com',
            'password' => Hash::make('12345678'),
            // 'is_active' => 1,
            'person_id' => $person->id,
        ]);

        AdministrativeUser::create([
            'user_id' => $user->id,
            'office_id' => $office->id,
        ]);
        */

        // Person::create([
        //     'name' => 'Deyber Antonio',
        //     'last_name' => 'Manrique',
        //     'second_last_name' => 'Acuña',
        //     'phone' => '123456789',
        //     'address' => 'Calle 123',
        //     'identity_number' => '12345678',
        //     'identity_type_id' => 1,
        // ]);

        // User::factory()->create([
        //     // 'name' => 'Test User',
        //     'email' => 'dbrmanrique@gmail.com',
        // 'person_id' => 1,
        // ]);
        
        
    }
}
