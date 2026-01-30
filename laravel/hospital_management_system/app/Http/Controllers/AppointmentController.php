<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('patient.book_appointment', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'time_slot' => 'required', // Now validated against logic below and date_format if needed
            'symptoms' => 'nullable|string',
        ]);

        $dayOfWeek = \Carbon\Carbon::parse($request->appointment_date)->format('l'); // e.g., Monday
        $requestTime = \Carbon\Carbon::parse($request->time_slot)->format('H:i');

        $schedule = \App\Models\Schedule::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$schedule || !$schedule->is_active) {
            return back()->withErrors(['time_slot' => "Doctor is not available on $dayOfWeek."])->withInput();
        }

        $startTime = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
        $endTime = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');

        if ($requestTime < $startTime || $requestTime > $endTime) {
            return back()->withErrors(['time_slot' => "Selected time is outside the doctor's schedule ($startTime - $endTime)."])->withInput();
        }

        $patient = Auth::user()->patient;

        Appointment::create([
            'appointment_number' => 'APP' . time(),
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'time_slot' => $request->time_slot,
            'status' => 'pending',
            'symptoms' => $request->symptoms,
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Appointment booked successfully!');
    }
}
