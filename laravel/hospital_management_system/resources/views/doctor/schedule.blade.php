@extends('layouts.app')

@section('header', 'My Schedule')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <h3 class="text-lg font-medium text-gray-900">Weekly Schedule</h3>
        <a href="{{ route('doctor.schedule.edit') }}" class="mt-4 md:mt-0 bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 inline-block text-center">
            Edit Schedule
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($schedules as $schedule)
        <div class="border rounded-md p-4 {{ $schedule->is_active ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
            <div class="flex items-center justify-between">
                <span class="font-bold text-gray-800">{{ ucfirst($schedule->day_of_week) }}</span>
                <span class="px-2 py-1 text-xs rounded-full {{ $schedule->is_active ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                    {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="mt-2 text-sm text-gray-600">
                <p>Start: <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</span></p>
                <p>End: <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</span></p>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-8 text-gray-500">
            No schedule slots defined.
        </div>
        @endforelse
    </div>
</div>
@endsection
