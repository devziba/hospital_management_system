<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_doctors' => Doctor::count(),
            'total_patients' => Patient::count(),
            'total_appointments' => Appointment::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function doctors()
    {
        $doctors = Doctor::with('user')->paginate(10);
        return view('admin.doctors', compact('doctors'));
    }

    public function patients()
    {
        $patients = Patient::with('user')->paginate(10);
        return view('admin.patients', compact('patients'));
    }

    public function appointments()
    {
        $appointments = Appointment::with(['doctor.user', 'patient.user'])->latest()->paginate(10);
        return view('admin.appointments', compact('appointments'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'specialization' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Casts verify hash automatically
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'doctor_number' => 'DOC' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
            'specialization' => $request->specialization,
            'department' => $request->department,
            'phone' => $request->phone,
            'availability_status' => 'available',
        ]);

        return redirect()->route('admin.doctors')->with('success', 'Doctor added successfully');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $user = $doctor->user;
        
        $doctor->delete();
        $user->delete();

        return redirect()->route('admin.doctors')->with('success', 'Doctor deleted successfully');
    }

    // Patient Management Methods
    public function createPatient()
    {
        return view('admin.patients.create');
    }

    public function storePatient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:5',
            'address' => 'nullable|string',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Helper handles hashing automatically
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id' => $user->id,
            'patient_number' => 'PAT' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.patients')->with('success', 'Patient added successfully');
    }

    public function destroyPatient($id)
    {
        $patient = Patient::findOrFail($id);
        $user = $patient->user;
        
        $patient->delete();
        $user->delete();

        return redirect()->route('admin.patients')->with('success', 'Patient deleted successfully');
    }
}
