<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedAdmin - @yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-active {
            background-color: #eff6ff;
            color: #2563eb !important;
            border-right: 4px solid #2563eb;
        }

        /* Smooth Sidebar Transitions */
        .nav-link {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-full z-50">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-black text-gray-800 flex items-center tracking-tighter">
                    <i class="ri-stethoscope-line text-blue-600 mr-2"></i>
                    Med<span class="text-blue-600">Admin</span>
                </h1>
                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-widest">Clinic Management</p>
            </div>

            <nav class="flex-1 p-4 overflow-y-auto">
                <div class="mb-8">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 px-4">Main Menu</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                            <i class="ri-dashboard-line mr-3 text-lg"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('admin.users.*') ? 'sidebar-active' : '' }}">
                            <i class="ri-user-line mr-3 text-lg"></i>
                            <span class="font-medium">Users & Admins</span>
                        </a>
                        <a href="{{ route('admin.doctors.index') }}"
                            class="nav-link flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('admin.doctors.*') ? 'sidebar-active' : '' }}">
                            <i class="ri-user-star-line mr-3 text-lg"></i>
                            <span class="font-medium">Doctors</span>
                        </a>
                        <a href="{{ route('admin.schedules.index') }}"
                            class="nav-link flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('admin.schedules.*') ? 'sidebar-active' : '' }}">
                            <i class="ri-calendar-line mr-3 text-lg"></i>
                            <span class="font-medium">Schedules</span>
                        </a>
                        <a href="{{ route('admin.appointments.index') }}"
                            class="nav-link flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('admin.appointments.*') ? 'sidebar-active' : '' }}">
                            <i class="ri-calendar-check-line mr-3 text-lg"></i>
                            <span class="font-medium">Appointments</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-2xl border border-gray-100">
                    <div class="flex items-center min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black shadow-md shadow-blue-100 flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3 truncate">
                            <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[9px] text-blue-600 font-black uppercase tracking-tighter">Admin</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors p-1">
                            <i class="ri-logout-box-r-line text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex-1 ml-64 flex flex-col">
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-40">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 tracking-tight">
                            @yield('title', 'Admin Panel')
                        </h2>
                    </div>

                    <div class="flex items-center space-x-4">

                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center space-x-3 p-1.5 pl-4 rounded-2xl hover:bg-gray-50 transition focus:outline-none">

                                <div class="text-right hidden md:block">
                                    <p class="text-sm font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-gray-500 mt-1 font-medium">{{ Auth::user()->email }}</p>
                                </div>

                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 border border-gray-200 shadow-sm">
                                    <i class="ri-user-3-line text-lg"></i>
                                </div>

                                <i class="ri-arrow-down-s-line text-gray-400 text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open"
                                x-cloak
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                class="absolute right-0 mt-3 w-60 bg-white border border-gray-200 rounded-2xl shadow-2xl py-2 z-50 shadow-blue-900/10">

                                <div class="px-4 py-3 border-b border-gray-50">
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Management</p>
                                </div>

                                <a href="{{ route('admin.profile.show') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition font-medium">
                                    <i class="ri-user-settings-line mr-3 text-lg opacity-70"></i> My Profile
                                </a>

                                <div class="border-t border-gray-50 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition font-bold">
                                        <i class="ri-shut-down-line mr-3 text-lg opacity-70"></i> Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-8">
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 flex items-center shadow-sm rounded-2xl">
                    <i class="ri-checkbox-circle-fill mr-3 text-xl text-green-500"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('modals')
    @yield('scripts')
</body>

</html>