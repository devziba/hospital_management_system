<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Doctor 1
        $user1 = User::create([
            'name' => 'Dr. Stephen Strange',
            'email' => 'doctor@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'email_verified_at' => now(),
        ]);

        $doc1 = Doctor::create([
            'user_id' => $user1->id,
            'doctor_number' => 'DOC001',
            'specialization' => 'Neurology',
            'qualification' => 'MD, PhD',
            'experience_years' => 15,
            'department' => 'Neurology',
            'consultation_fee' => 1500.00,
            'availability_status' => 'available',
        ]);

        // Schedule for Doc 1
        Schedule::create([
            'doctor_id' => $doc1->id,
            'day_of_week' => 'monday',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);
        Schedule::create([
            'doctor_id' => $doc1->id,
            'day_of_week' => 'wednesday',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        // Doctor 2
        $user2 = User::create([
            'name' => 'Dr. Gregory House',
            'email' => 'house@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'email_verified_at' => now(),
        ]);

        $doc2 = Doctor::create([
            'user_id' => $user2->id,
            'doctor_number' => 'DOC002',
            'specialization' => 'Diagnostic Medicine',
            'qualification' => 'MD',
            'experience_years' => 20,
            'department' => 'Diagnostics',
            'consultation_fee' => 2000.00,
            'availability_status' => 'available',
        ]);

        Schedule::create([
            'doctor_id' => $doc2->id,
            'day_of_week' => 'tuesday',
            'start_time' => '10:00:00',
            'end_time' => '16:00:00',
        ]);
    }
}
