<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedAdmin - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .sidebar-active {
            background-color: #eff6ff;
            color: #2563eb !important;
            border-right: 4px solid #2563eb;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-full">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="ri-stethoscope-line text-blue-600 mr-2"></i>
                    MedAdmin
                </h1>
                <p class="text-sm text-gray-500 mt-1">Admin Panel</p>
            </div>

            <nav class="flex-1 p-4 overflow-y-auto">
                <div class="mb-8">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">MAIN MENU</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                            <i class="ri-dashboard-line mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('admin.users.*') ? 'sidebar-active' : '' }}">
                            <i class="ri-user-line mr-3"></i>
                            Users & Admins
                        </a>
                        <a href="{{ route('admin.doctors.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('admin.doctors.*') ? 'sidebar-active' : '' }}">
                            <i class="ri-user-star-line mr-3"></i>
                            Doctors
                        </a>
                        <a href="{{ route('admin.schedules.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('admin.schedules.*') ? 'sidebar-active' : '' }}">
                            <i class="ri-calendar-line mr-3"></i>
                            Schedules
                        </a>
                        <a href="{{ route('admin.appointments.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('admin.appointments.*') ? 'sidebar-active' : '' }}">
                            <i class="ri-calendar-check-line mr-3"></i>
                            Appointments
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl">
                    <div class="flex items-center min-w-0">
                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3 truncate">
                            <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-500 uppercase tracking-tighter">
                                {{ Auth::user()->role == 1 ? 'Administrator' : 'User' }}
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors ml-2">
                            <i class="ri-logout-box-r-line text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex-1 ml-64 flex flex-col">
            <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">
                            @yield('title', 'Admin Panel')
                        </h2>
                    </div>

                    <div class="flex items-center space-x-6">
                        <button class="p-2 text-gray-400 hover:text-blue-600 relative transition">
                            <i class="ri-notification-3-line text-xl"></i>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>

                        <div class="relative dropdown group">
                            <button class="flex items-center space-x-3 focus:outline-none">
                                <div class="text-right hidden md:block">
                                    <p class="text-sm font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full border-2 border-blue-50 p-0.5">
                                    <div class="w-full h-full rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                                        <i class="ri-user-3-fill"></i>
                                    </div>
                                </div>
                            </button>

                            <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-2xl shadow-2xl py-2 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-50">
                                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Account</p>
                                </div>
                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                    <i class="ri-settings-4-line mr-3 text-lg opacity-70"></i> Profile Settings
                                </a>
                                <hr class="my-1 border-gray-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
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
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 flex items-center shadow-sm rounded-r-lg">
                    <i class="ri-checkbox-circle-fill mr-3 text-xl"></i>
                    {{ session('success') }}
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