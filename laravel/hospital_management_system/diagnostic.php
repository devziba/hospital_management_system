<?php
// Diagnostic script to check appointments
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;

echo "=== ALL APPOINTMENTS ===\n\n";

$appointments = Appointment::with(['doctor.user', 'patient.user'])->get();

foreach ($appointments as $apt) {
    echo "Appointment ID: {$apt->id}\n";
    echo "Number: {$apt->appointment_number}\n";
    echo "Date: {$apt->appointment_date}\n";
    echo "Time: {$apt->time_slot}\n";
    echo "Status: {$apt->status}\n";
    echo "Doctor ID: {$apt->doctor_id} - " . ($apt->doctor ? $apt->doctor->user->name : 'N/A') . "\n";
    echo "Patient ID: {$apt->patient_id} - " . ($apt->patient ? $apt->patient->user->name : 'N/A') . "\n";
    echo "---\n";
}

echo "\n=== DOCTORS ===\n\n";

$doctors = Doctor::with('user')->get();
foreach ($doctors as $doc) {
    echo "Doctor ID: {$doc->id}\n";
    echo "User ID: {$doc->user_id}\n";
    echo "Name: {$doc->user->name}\n";
    echo "Email: {$doc->user->email}\n";
    echo "---\n";
}

echo "\n=== TODAY'S DATE ===\n";
echo today()->toDateString() . "\n";
