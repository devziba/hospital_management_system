@extends('layouts.app')

@section('header', 'All Appointments')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-gray-700 font-medium">Appointments List</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($appointments as $appointment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appointment->appointment_number ?? $appointment->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->user->name ?? 'Unknown' }}</div>
                        <div class="text-sm text-gray-500">{{ $appointment->patient->patient_number ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $appointment->doctor->user->name ?? 'Unknown' }}</div>
                        <div class="text-sm text-gray-500">{{ $appointment->doctor->specialization ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $appointment->status === 'approved' ? 'bg-green-100 text-green-800' : 
                               ($appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($appointment->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucfirst($appointment->type ?? 'General') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
