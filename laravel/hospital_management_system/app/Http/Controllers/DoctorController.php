<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class DoctorController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;
        
        $todays_appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->with(['patient.user'])
            ->get();
            
        $upcoming_appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', today())
            ->whereIn('status', ['confirmed', 'pending'])
            ->take(5)
            ->get();

        return view('doctor.dashboard', compact('todays_appointments', 'upcoming_appointments'));
    }

    public function appointments()
    {
        $doctor = Auth::user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient.user'])
            ->latest()
            ->paginate(10);

        return view('doctor.appointments', compact('appointments'));
    }

    public function patients()
    {
        // Logic to get patients associated with this doctor (e.g., via appointments)
        $doctor = Auth::user()->doctor;
        $patients = \App\Models\Patient::whereHas('appointments', function($q) use ($doctor) {
            $q->where('doctor_id', $doctor->id);
        })->with('user')->distinct()->paginate(10);
        
        return view('doctor.patients', compact('patients'));
    }

    public function schedule()
    {
        $doctor = Auth::user()->doctor;
        $schedules = $doctor->schedules;
        return view('doctor.schedule', compact('schedules'));
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        // Ensure the appointment belongs to the logged-in doctor
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed',
        ]);

        $appointment->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Appointment status updated successfully.');
    }

    public function editSchedule()
    {
        $doctor = Auth::user()->doctor;
        // Ensure we have a collection of schedules, even if empty, keyed by day would be nice but a list is fine
        // We can check if schedules exist, if not, we can pass an empty structure or handle in view
        $formatted_schedules = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        foreach($days as $day) {
            $schedule = $doctor->schedules()->where('day_of_week', $day)->first();
            $formatted_schedules[$day] = $schedule;
        }

        return view('doctor.schedule.edit', compact('formatted_schedules', 'days'));
    }

    public function updateSchedule(Request $request)
    {
        $doctor = Auth::user()->doctor;
        
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.start_time' => 'nullable|date_format:H:i',
            'schedules.*.end_time' => 'nullable|date_format:H:i|after:schedules.*.start_time',
        ]);

        foreach ($request->schedules as $day => $times) {
            // If active (checkbox checked) or times provided, save/update
            // Assuming simpler logic: if checkbox 'is_active' is present, it's active.
            
            $isActive = isset($times['is_active']);
            
            \App\Models\Schedule::updateOrCreate(
                [
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $day,
                ],
                [
                    'start_time' => $times['start_time'] ?? null,
                    'end_time' => $times['end_time'] ?? null,
                    'is_active' => $isActive,
                ]
            );
        }

        return redirect()->route('doctor.schedule')->with('success', 'Schedule updated successfully');
    }
}
