<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'patient@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'email_verified_at' => now(),
        ]);

        Patient::create([
            'user_id' => $user->id,
            'patient_number' => 'PAT001',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'blood_group' => 'O+',
            'phone' => '1234567890',
            'address' => '123 Main St, New York, NY',
        ]);
    }
}
