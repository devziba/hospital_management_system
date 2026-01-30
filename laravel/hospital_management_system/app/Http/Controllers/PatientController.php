<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class PatientController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;
        
        if (!$patient) {
            // Handle case where patient profile isn't created yet
            return view('patient.dashboard', ['upcoming_appointments' => []]);
        }

        $upcoming_appointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', today())
            ->with(['doctor.user'])
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        return view('patient.dashboard', compact('upcoming_appointments'));
    }

    public function appointments()
    {
        $patient = Auth::user()->patient;
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user'])
            ->latest()
            ->paginate(10);

        return view('patient.appointments', compact('appointments'));
    }

    public function history()
    {
        $patient = Auth::user()->patient;
        $history = $patient->medical_history ?? []; // Assuming JSON column
        $past_appointments = Appointment::where('patient_id', $patient->id)
            ->where('status', 'completed')
            ->get();

        return view('patient.history', compact('history', 'past_appointments'));
    }
}
