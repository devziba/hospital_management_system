@extends('layouts.patient')

@section('header', 'Dashboard')
@section('subheader', 'Welcome back, ' . Auth::user()->name . '!')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Quick Actions & Stats -->
    <div class="space-y-8">
        <!-- Quick Actions Card -->
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
            <h2 class="text-xl font-bold mb-2">My Health Actions</h2>
            <p class="text-teal-50 mb-6">Manage your appointments and view your history.</p>
            
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('patient.book_appointment') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-xl p-4 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="font-semibold block">Book New</span>
                    <span class="text-xs opacity-80">Appointment</span>
                </a>

                <a href="{{ route('patient.history') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-xl p-4 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-semibold block">History</span>
                    <span class="text-xs opacity-80">Medical Records</span>
                </a>
            </div>
        </div>

        <!-- Mini Cal or Info (Placeholder for now, maybe add later) -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800">Next Visit</h3>
                <span class="text-xs font-semibold bg-teal-50 text-teal-600 px-2 py-1 rounded-full">Coming Soon</span>
            </div>
            @if($upcoming_appointments->count() > 0)
                @php $next = $upcoming_appointments->first(); @endphp
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-teal-50 rounded-xl flex flex-col items-center justify-center text-teal-600 font-bold border border-teal-100">
                        <span class="text-xs uppercase">{{ \Carbon\Carbon::parse($next->appointment_date)->format('M') }}</span>
                        <span class="text-lg leading-none">{{ \Carbon\Carbon::parse($next->appointment_date)->format('d') }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $next->doctor->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $next->doctor->specialization }}</p>
                        <p class="text-sm font-medium text-teal-600 mt-1">{{ \Carbon\Carbon::parse($next->time_slot)->format('h:i A') }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-sm">No upcoming appointments scheduled.</p>
            @endif
        </div>
    </div>

    <!-- Right Column: Upcoming Appointments List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800 text-lg">Upcoming Appointments</h3>
                <a href="{{ route('patient.appointments') }}" class="text-teal-600 text-sm font-medium hover:text-teal-700 flex items-center">
                    View All
                    <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($upcoming_appointments as $appointment)
                    <div class="p-4 hover:bg-gray-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start sm:items-center space-x-4">
                             <div class="flex-shrink-0 w-12 h-12 bg-teal-50 rounded-full flex items-center justify-center border border-teal-100">
                                <svg class="w-6 h-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Dr. {{ $appointment->doctor->user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $appointment->doctor->specialization }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                            <div class="text-right">
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->time_slot)->format('h:i A') }}</p>
                            </div>
                            
                            <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ 
                                $appointment->status == 'confirmed' ? 'bg-green-50 text-green-700 border-green-200' : 
                                ($appointment->status == 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 
                                'bg-gray-50 text-gray-700 border-gray-200') 
                            }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No appointments scheduled</h3>
                        <p class="mt-1">Book your first appointment to get started.</p>
                        <div class="mt-6">
                            <a href="{{ route('patient.book_appointment') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-teal-600 hover:bg-teal-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Book Appointment
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

