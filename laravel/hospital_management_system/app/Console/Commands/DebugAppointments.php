<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Doctor;

class DebugAppointments extends Command
{
    protected $signature = 'debug:appointments';
    protected $description = 'Debug appointment display issues';

    public function handle()
    {
        $this->info("=== ALL APPOINTMENTS ===\n");

        $appointments = Appointment::with(['doctor.user', 'patient.user'])->get();

        foreach ($appointments as $apt) {
            $this->line("Appointment ID: {$apt->id}");
            $this->line("Number: {$apt->appointment_number}");
            $this->line("Date: {$apt->appointment_date}");
            $this->line("Time: {$apt->time_slot}");
            $this->line("Status: {$apt->status}");
            $this->line("Doctor ID: {$apt->doctor_id} - " . ($apt->doctor ? $apt->doctor->user->name : 'N/A'));
            $this->line("Patient ID: {$apt->patient_id} - " . ($apt->patient ? $apt->patient->user->name : 'N/A'));
            $this->line("---");
        }

        $this->info("\n=== DOCTORS ===\n");

        $doctors = Doctor::with('user')->get();
        foreach ($doctors as $doc) {
            $this->line("Doctor ID: {$doc->id}");
            $this->line("User ID: {$doc->user_id}");
            $this->line("Name: {$doc->user->name}");
            $this->line("Email: {$doc->user->email}");
            $this->line("---");
        }

        $this->info("\n=== TODAY'S DATE ===");
        $this->line(today()->toDateString());
        
        return 0;
    }
}
