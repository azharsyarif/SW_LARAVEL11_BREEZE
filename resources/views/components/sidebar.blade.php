<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-gray-900 text-white h-full fixed top-0 left-0 overflow-y-auto">
    <div class="p-6">
        <!-- Application Name -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">{{ config('app.name', 'Laravel') }}</h1>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-6">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-md hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}">
                <span class="text-lg">Dashboard</span>
            </a>

            <!-- HR Section -->
            <div>
                <button class="flex items-center justify-between w-full p-3 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700" onclick="toggleDropdown('hrDropdown')">
                    <span class="text-lg">HR</span>
                    <svg id="hrDropdownIcon" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="hrDropdown" class="mt-2 space-y-2 pl-6 {{ request()->routeIs('user.index') ? '' : 'hidden' }}">
                    <a href="{{ route('user.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('user.index') ? 'bg-gray-800' : '' }}">Karyawan</a>
                    <a href="{{ route('attendances.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('attendances.index') ? 'bg-gray-800' : '' }}">Absensi</a>
                    <a href="{{ route('pengajuan.cuti.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('pengajuan.cuti.index') ? 'bg-gray-800' : '' }}">Permohonan Cuti</a>
                    <a href="{{ route('pengajuan.izin-sakit.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('pengajuan.izin-sakit.index') ? 'bg-gray-800' : '' }}">Permohonan Izin/Sakit</a>
                    <a href="{{ route('approval.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('approval.index') ? 'bg-gray-800' : '' }}">Approval Izin/Sakit/Cuti</a>
                </div>
            </div>

            <!-- REKANAN Section -->
            <div>
                <button class="flex items-center justify-between w-full p-3 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700" onclick="toggleDropdown('rekananDropdown')">
                    <span class="text-lg">REKANAN</span>
                    <svg id="rekananDropdownIcon" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="rekananDropdown" class="mt-2 space-y-2 pl-6 {{ request()->routeIs('rekanan.index') ? '' : 'hidden' }}">
                    <a href="{{ route('rekanan.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('rekanan.index') ? 'bg-gray-800' : '' }}">Data Rekanan</a>
                    <a href="{{ route('pic.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('pic.index') ? 'bg-gray-800' : '' }}">PIC Customer</a>
                </div>
            </div>

            <!-- MARKETING Section -->
            @if(auth()->check() && (auth()->user()->divisions->contains('name', 'marketing') || auth()->user()->role_id == 1))
            <div>
                <button class="flex items-center justify-between w-full p-3 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700" onclick="toggleDropdown('marketingDropdown')">
                    <span class="text-lg">MARKETING</span>
                    <svg id="marketingDropdownIcon" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="marketingDropdown" class="mt-2 space-y-2 pl-6 {{ request()->routeIs('marketing.po.index') ? '' : 'hidden' }}">
                    <a href="{{ route('marketing.po.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('marketing.po.index') ? 'bg-gray-800' : '' }}">PO Customer</a>
                    <a href="{{ route('marketing.order.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('marketing.order.index') ? 'bg-gray-800' : '' }}">Order Management</a>
                    <a href="{{ route('marketing.invoice.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('marketing.invoice.index') ? 'bg-gray-800' : '' }}">Invoice Management</a>
                </div>
            </div>
            @endif
            <!-- FINANCE Section -->
            <div>
                <button class="flex items-center justify-between w-full p-3 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700" onclick="toggleDropdown('financeDropdown')">
                    <span class="text-lg">FINANCE</span>
                    <svg id="financeDropdownIcon" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="financeDropdown" class="mt-2 space-y-2 pl-6 {{ request()->routeIs('approvalPayment-index') ? '' : 'hidden' }}">
                    <a href="{{ route('approvalPayment-index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('approvalPayment-index') ? 'bg-gray-800' : '' }}">Payment Finance</a>
                </div>
            </div>
            <!-- OPERASIONAL Section -->
            <div>
                <button class="flex items-center justify-between w-full p-3 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700" onclick="toggleDropdown('operasionalDropdown')">
                    <span class="text-lg">OPERASIONAL</span>
                    <svg id="operasionalDropdownIcon" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="operasionalDropdown" class="mt-2 space-y-2 pl-6 {{ request()->routeIs('intruksiJalan.index') ? '' : 'hidden' }}">
                    <a href="{{ route('intruksiJalan.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('intruksiJalan.index') ? 'bg-gray-800' : '' }}">Intruksi Jalan</a>
                    <a href="{{ route('kendaraan.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('kendaraan.index') ? 'bg-gray-800' : '' }}">Data Kendaraan</a>
                    <a href="{{ route('service.index') }}" class="block p-2 text-gray-300 rounded-md hover:bg-gray-700 {{ request()->routeIs('service.index') ? 'bg-gray-800' : '' }}">Service Kendaraan</a>
                </div>
            </div>

            <!-- Profile Section -->
            <a href="{{ route('profile.index') }}" class="flex items-center space-x-3 p-3 rounded-md hover:bg-gray-700 {{ request()->routeIs('profile.index') ? 'bg-gray-800' : '' }}">
                <span class="text-lg">Profile</span>
            </a>

            <!-- Logout Button -->
            <div class="mt-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left p-3 rounded-md text-red-400 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-700">
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>
</aside>

<script>
    // Toggle dropdown visibility
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const icon = document.getElementById(dropdownId + 'Icon');

        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            dropdown.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
