<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patient = Patient::whereHas('user', function ($q) {
            $q->where('email', 'patient@hospital.com');
        })->first();

        $doctor1 = Doctor::whereHas('user', function ($q) {
            $q->where('email', 'doctor@hospital.com');
        })->first();

        $doctor2 = Doctor::whereHas('user', function ($q) {
            $q->where('email', 'house@hospital.com');
        })->first();

        if ($patient && $doctor1 && $doctor2) {
            // Future Appointment
            Appointment::create([
                'appointment_number' => 'APP' . time(),
                'patient_id' => $patient->id,
                'doctor_id' => $doctor1->id,
                'appointment_date' => now()->addDays(2),
                'time_slot' => '10:00:00',
                'status' => 'confirmed',
                'symptoms' => 'Regular checkup',
            ]);

            // Pending Appointment
            Appointment::create([
                'appointment_number' => 'APP' . (time() + 1),
                'patient_id' => $patient->id,
                'doctor_id' => $doctor2->id,
                'appointment_date' => now()->addDays(5),
                'time_slot' => '14:00:00',
                'status' => 'pending',
                'symptoms' => 'Persistent headache',
            ]);

            // Past Completed Appointment
            Appointment::create([
                'appointment_number' => 'APP' . (time() - 1000),
                'patient_id' => $patient->id,
                'doctor_id' => $doctor1->id,
                'appointment_date' => now()->subMonths(1),
                'time_slot' => '09:00:00',
                'status' => 'completed',
                'symptoms' => 'Flu symptoms',
                'notes' => 'Patient recovered given prescribed medication.',
            ]);
        }
    }
}
