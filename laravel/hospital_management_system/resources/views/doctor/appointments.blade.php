@extends('layouts.app')

@section('header', 'My Appointments')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <!-- Filter/Search Header can go here -->
    
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Symptoms</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($appointments as $appointment)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->time_slot)->format('h:i A') }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $appointment->patient->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $appointment->patient->patient_number }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                    {{ $appointment->symptoms ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $appointment->status == 'confirmed' ? 'bg-green-100 text-green-800' : 
                           ($appointment->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($appointment->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-2">
                        @if($appointment->status == 'pending')
                            <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 px-3 py-1 rounded-md text-xs font-medium border border-green-200 hover:bg-green-100 transition-colors">
                                    Confirm
                                </button>
                            </form>
                            
                            <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this appointment?');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md text-xs font-medium border border-red-200 hover:bg-red-100 transition-colors">
                                    Reject
                                </button>
                            </form>
                        @elseif($appointment->status == 'confirmed')
                             <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded-md text-xs font-medium border border-blue-200 hover:bg-blue-100 transition-colors">
                                    Complete
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-xs italic">No actions</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                    No appointments found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
