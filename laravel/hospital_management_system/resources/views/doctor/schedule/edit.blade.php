@extends('layouts.app')

@section('header', 'Edit Schedule')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900">Define Weekly Availability</h3>
        <p class="text-sm text-gray-500">Set your start and end times for each day. Uncheck the box to mark a day as unavailable.</p>
    </div>

    <form action="{{ route('doctor.schedule.update') }}" method="POST">
        @csrf
        
        <div class="space-y-4">
            @foreach($days as $day)
            @php
                $schedule = $formatted_schedules[$day] ?? null;
                $isActive = $schedule ? $schedule->is_active : false;
                $startTime = $schedule ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '';
                $endTime = $schedule ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '';
            @endphp
            
            <div class="flex items-center space-x-4 p-4 border rounded-md bg-gray-50">
                <div class="w-1/4">
                    <div class="flex items-center h-5">
                        <input id="day_{{ $day }}" name="schedules[{{ $day }}][is_active]" type="checkbox" value="1" {{ $isActive ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="day_{{ $day }}" class="ml-3 font-medium text-gray-700">{{ $day }}</label>
                    </div>
                </div>
                
                <div class="w-1/3">
                    <label for="start_{{ $day }}" class="block text-xs font-medium text-gray-500">Start Time</label>
                    <input type="time" name="schedules[{{ $day }}][start_time]" id="start_{{ $day }}" value="{{ $startTime }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                
                <div class="w-1/3">
                    <label for="end_{{ $day }}" class="block text-xs font-medium text-gray-500">End Time</label>
                    <input type="time" name="schedules[{{ $day }}][end_time]" id="end_{{ $day }}" value="{{ $endTime }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-end">
            <a href="{{ route('doctor.schedule') }}" class="mr-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Save Schedule
            </button>
        </div>
    </form>
</div>
@endsection
