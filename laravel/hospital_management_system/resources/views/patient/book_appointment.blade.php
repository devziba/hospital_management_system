@extends('layouts.patient')

@section('header', 'Book Appointment')
@section('subheader', 'Schedule a visit with one of our specialists.')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('patient.store_appointment') }}" class="space-y-6">
            @csrf

            <!-- Doctor Selection -->
            <div>
                <label for="doctor_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Specialist</label>
                <div class="relative">
                    <select id="doctor_id" name="doctor_id" required 
                        class="block w-full pl-4 pr-10 py-3 text-base border-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-xl transition-all shadow-sm">
                        <option value="">Choose a doctor...</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>Dr. {{ $doctor->user->name }} - {{ $doctor->specialization }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date Selection -->
                <div>
                    <label for="appointment_date" class="block text-sm font-semibold text-gray-700 mb-2">Preferred Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" required min="{{ date('Y-m-d') }}" value="{{ old('appointment_date') }}"
                        class="block w-full border-gray-200 rounded-xl shadow-sm py-3 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all">
                    @error('appointment_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Slot -->
                <div>
                    <label for="time_slot" class="block text-sm font-semibold text-gray-700 mb-2">Time Slot</label>
                    <input type="time" name="time_slot" id="time_slot" required value="{{ old('time_slot') }}"
                        class="block w-full border-gray-200 rounded-xl shadow-sm py-3 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all">
                    @error('time_slot')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Clinic hours: 09:00 AM - 05:00 PM
                    </p>
                </div>
            </div>

            <!-- Symptoms -->
            <div>
                <label for="symptoms" class="block text-sm font-semibold text-gray-700 mb-2">Symptoms / Reason for Visit</label>
                <textarea id="symptoms" name="symptoms" rows="4" placeholder="Briefly describe your symptoms or reason for visit..."
                    class="block w-full border-gray-200 rounded-xl shadow-sm py-3 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-all"></textarea>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('patient.dashboard') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-200 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all">
                    Confirm Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
