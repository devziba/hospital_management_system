@extends('layouts.patient')

@section('header', 'Medical History')
@section('subheader', 'Your health journey and past records.')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Impact Summary / Conditions -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Medical Conditions
            </h3>
            
            @if(!empty($history))
                <div class="flex flex-wrap gap-2">
                    @foreach($history as $item)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-50 text-teal-700 border border-teal-100">
                            {{ $item }}
                        </span>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 italic text-sm">No specific medical conditions recorded.</p>
                </div>
            @endif
        </div>

        <!-- Quick Stats (Example) -->
         <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white">
            <h4 class="font-bold text-lg mb-2">Total Visits</h4>
            <div class="text-4xl font-bold mb-1">{{ $past_appointments->count() }}</div>
            <p class="text-teal-50 text-sm">Completed appointments to date.</p>
        </div>
    </div>

    <!-- Right Column: Timeline of Visits -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Past Visits History</h3>
            
            <div class="relative border-l-2 border-gray-100 ml-3 space-y-8">
                @forelse($past_appointments as $appointment)
                    <div class="relative pl-8">
                        <!-- Timeline Dot -->
                        <div class="absolute -left-2.5 top-0 w-5 h-5 rounded-full bg-white border-4 border-teal-500"></div>
                        
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                            <div>
                                <span class="text-sm text-gray-500 font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                                <h4 class="text-base font-semibold text-gray-900 mt-1">
                                    Appointment with Dr. {{ $appointment->doctor->user->name }}
                                </h4>
                                <p class="text-sm text-teal-600">{{ $appointment->doctor->specialization }}</p>
                                
                                @if($appointment->notes)
                                    <div class="mt-3 bg-gray-50/50 rounded-lg p-3 text-sm text-gray-600 border border-gray-100">
                                        <span class="font-semibold text-gray-700 block mb-1">Doctor's Notes:</span>
                                        {{ $appointment->notes }}
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-400 italic">No notes available for this visit.</p>
                                @endif
                            </div>
                            
                            <!-- Details link removed as notes are shown inline -->
                        </div>
                    </div>
                @empty
                    <div class="pl-8">
                        <p class="text-gray-500">No past medical history found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
