@extends('layouts.app')

@section('header', 'Add New Doctor')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form method="POST" action="{{ route('admin.doctors.store') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
             @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Specialization -->
        <div>
            <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
            <select name="specialization" id="specialization" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">Select Specialization</option>
                <option value="General Practice">General Practice</option>
                <option value="Cardiology">Cardiology</option>
                <option value="Neurology">Neurology</option>
                <option value="Pediatrics">Pediatrics</option>
                <option value="Orthopedics">Orthopedics</option>
                <option value="Dermatology">Dermatology</option>
                <option value="Surgery">Surgery</option>
            </select>
             @error('specialization')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Department -->
        <div>
            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
            <select name="department" id="department" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">Select Department</option>
                <option value="Outpatient">Outpatient</option>
                <option value="Inpatient">Inpatient</option>
                <option value="Emergency">Emergency</option>
                <option value="Surgery">Surgery</option>
                <option value="Diagnostics">Diagnostics</option>
            </select>
            @error('department')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
             @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end pt-4">
            <a href="{{ route('admin.doctors') }}" class="mr-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create Doctor Account
            </button>
        </div>
    </form>
</div>
@endsection
