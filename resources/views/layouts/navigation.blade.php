<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                            <span class="text-white font-bold text-lg">M</span>
                        </div>
                        <span class="font-bold text-xl text-gray-800">MedCLINIC</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                    <x-nav-link href="/dashboard" :active="request()->is('dashboard')">Dashboard</x-nav-link>
                    <x-nav-link href="/doctors" :active="request()->is('doctors*')">Doctors</x-nav-link>
                    <x-nav-link href="/appointments" :active="request()->is('appointments*')">Appointments</x-nav-link>
                    @else
                    <x-nav-link href="/">Home</x-nav-link>
                    <x-nav-link href="/#about">About Us</x-nav-link>
                    <x-nav-link href="/#contact">Contact</x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                        <div>{{ Auth::user()->name }}</div>
                        <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                        @if(Auth::user()->role == 1)
                        <a href="/admin/dashboard" class="block px-4 py-2 text-sm text-purple-600 font-bold hover:bg-gray-100">Admin Panel</a>
                        @endif
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>

                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Log Out</button>
                        </form>

                    </div>
                </div>
                @else
                <a href="/login" class="text-gray-600 hover:text-gray-900 font-medium px-3 py-2">Login</a>
                <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg ml-2 shadow-md">Register</a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-400 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">

                        <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t">
        <div class="pt-2 pb-3 space-y-1">
            @auth
            <x-responsive-nav-link href="/dashboard">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link href="/doctors">Doctors</x-responsive-nav-link>
            @else
            <x-responsive-nav-link href="/">Home</x-responsive-nav-link>
            <x-responsive-nav-link href="/login">Login</x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>