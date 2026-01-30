<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 fixed h-full z-10 hidden md:block">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <span class="text-xl font-bold text-blue-600">MediCare HMS</span>
            </div>
            
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
                @auth
                    <!-- Admin Menu -->
                    @if(auth()->user()->isAdmin())
                        <x-nav-link route="admin.dashboard" icon="home">Dashboard</x-nav-link>
                        <x-nav-link route="admin.doctors" icon="users">Doctors</x-nav-link>
                        <x-nav-link route="admin.patients" icon="user-group">Patients</x-nav-link>
                        <x-nav-link route="admin.appointments" icon="calendar">All Appointments</x-nav-link>
                    @endif

                    <!-- Doctor Menu -->
                    @if(auth()->user()->isDoctor())
                        <x-nav-link route="doctor.dashboard" icon="home">Dashboard</x-nav-link>
                        <x-nav-link route="doctor.schedule" icon="clock">My Schedule</x-nav-link>
                        <x-nav-link route="doctor.appointments" icon="calendar">Appointments</x-nav-link>
                        <x-nav-link route="doctor.patients" icon="users">My Patients</x-nav-link>
                    @endif

                    <!-- Patient Menu -->
                    @if(auth()->user()->isPatient())
                        <x-nav-link route="patient.dashboard" icon="home">Dashboard</x-nav-link>
                        <x-nav-link route="patient.appointments" icon="calendar">My Appointments</x-nav-link>
                        <x-nav-link route="patient.book_appointment" icon="plus-circle">Book Appointment</x-nav-link>
                        <x-nav-link route="patient.history" icon="clipboard-document-list">Medical History</x-nav-link>
                    @endif
                @endauth
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-10">
                <h1 class="text-xl font-semibold text-gray-800">
                    @yield('header', 'Dashboard')
                </h1>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center space-x-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <!-- Dropdown -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg py-1 z-50 display-none"
                                 style="display: none;">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Login</a>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 bg-gray-50">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
