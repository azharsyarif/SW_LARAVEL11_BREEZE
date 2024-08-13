<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Ensure the button is clickable */
        #hamburgerButton {
            position: relative;
            z-index: 1000;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-gray-800 text-white h-screen fixed top-0 left-0 transform md:translate-x-0 transition-transform duration-300">
            <div class="p-6">
                <!-- Application Name -->
                <div class="mb-6">
                    <h1 class="text-xl font-semibold">{{ config('app.name', 'Laravel') }}</h1>
                </div>
        
                <!-- HR Section -->
                <div class="mb-4">
                    <button class="w-full text-left p-4 hover:bg-gray-700 rounded-md flex justify-between items-center" onclick="toggleDropdown('hrDropdown')">
                        <span>HR</span>
                        <svg class="w-4 h-4 transform transition-transform duration-300" id="hrDropdownIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="hrDropdown" class="{{ request()->routeIs('user.index') ? '' : 'hidden' }}">
                        <ul class="pl-6 space-y-1">
                            <li>
                                <a href="{{ route('user.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('user.index') ? 'bg-gray-700' : '' }}">Karyawan</a>
                            </li>
                            <li>
                                <a href="{{ route('user.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('user.index') ? 'bg-gray-700' : '' }}">Absensi</a>
                            </li>
                            <li>
                                <a href="{{ route('pengajuan.cuti.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('pengajuan.cuti.index') ? 'bg-gray-700' : '' }}">Permohonan Cuti</a>
                            </li>
                            <li>
                                <a href="{{ route('pengajuan.izin-sakit.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('pengajuan.izin-sakit.index') ? 'bg-gray-700' : '' }}">Permohonan Izin/Sakit</a>
                            </li>
                        </ul>
                    </div>
                </div>
        
                <!-- REKANAN Section -->
                <div class="mb-4">
                    <button class="w-full text-left p-4 hover:bg-gray-700 rounded-md flex justify-between items-center" onclick="toggleDropdown('rekananDropdown')">
                        <span>REKANAN</span>
                        <svg class="w-4 h-4 transform transition-transform duration-300" id="rekananDropdownIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="rekananDropdown" class="{{ request()->routeIs('rekanan.index') ? '' : 'hidden' }}">
                        <ul class="pl-6 space-y-1">
                            <li>
                                <a href="{{ route('rekanan.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('rekanan.index') ? 'bg-gray-700' : '' }}">Data Rekanan</a>
                            </li>
                            <li>
                                <a href="{{ route('pic.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('pic.index') ? 'bg-gray-700' : '' }}">PIC Customer</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mb-4">
                    <button class="w-full text-left p-4 hover:bg-gray-700 rounded-md flex justify-between items-center" onclick="toggleDropdown('marketingDropdown')">
                        <span>MARKETING</span>
                        <svg class="w-4 h-4 transform transition-transform duration-300" id="marketingDropdownIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="marketingDropdown" class="{{ request()->routeIs('marketing.po.index') ? '' : 'hidden' }}">
                        <ul class="pl-6 space-y-1">
                            <li>
                                <a href="{{ route('marketing.po.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('marketing.po.index') ? 'bg-gray-700' : '' }}">PO Customer</a>
                            </li>
                            <li>
                                <a href="{{ route('marketing.order.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('marketing.order.index') ? 'bg-gray-700' : '' }}">Order Management</a>
                            </li>
                            <li>
                                <a href="{{ route('pic.index') }}" class="block p-4 hover:bg-gray-700 rounded-md {{ request()->routeIs('pic.index') ? 'bg-gray-700' : '' }}">Invoice Management</a>
                            </li>
                        </ul>
                    </div>
                </div>
        
                <!-- Tambahan kode untuk kategori lain dengan pola yang sama -->
                
                <!-- Logout Button -->
                <div class="mt-6">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full py-2 px-4 text-red-500 hover:bg-gray-700 rounded-md">Logout</button>
                    </form>
                </div>
            </div>
        </aside>
        
        <script>
            // Fungsi untuk mengatur dropdown dengan localStorage
            function toggleDropdown(dropdownId) {
                const dropdown = document.getElementById(dropdownId);
                const icon = document.getElementById(dropdownId + 'Icon');
                
                dropdown.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
        
                // Simpan status dropdown di localStorage
                if (!dropdown.classList.contains('hidden')) {
                    localStorage.setItem(dropdownId, 'open');
                } else {
                    localStorage.removeItem(dropdownId);
                }
            }
        
            // Fungsi untuk memeriksa dan membuka dropdown yang telah dibuka sebelumnya
            document.addEventListener('DOMContentLoaded', function() {
                const dropdownIds = ['hrDropdown', 'rekananDropdown','marketingDropdown']; // Tambahkan id dropdown lain yang perlu diatur
                
                dropdownIds.forEach(function(id) {
                    if (localStorage.getItem(id) === 'open') {
                        document.getElementById(id).classList.remove('hidden');
                        document.getElementById(id + 'Icon').classList.add('rotate-180');
                    }
                });
            });
        </script>
        
        
        
        

        <!-- Main Content -->
        <div class="flex-1 ml-0 md:ml-64">
            <!-- Hamburger Menu Button -->
            <button id="hamburgerButton" class="p-4 text-gray-500 md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#hamburgerButton').on('click', function() {
                $('#sidebar').toggleClass('-translate-x-full translate-x-0');
            });
        });
    </script>
</body>
</html>
