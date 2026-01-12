@extends('layouts.admin')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight uppercase">Edit Administrator Profile</h2>
                <p class="text-sm text-gray-500">Update your account and contact information below.</p>
            </div>
            <a href="{{ route('admin.profile.show') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-bold text-xs text-blue-600 uppercase tracking-widest hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                View Profile
            </a>
        </div>

        <div class="bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-gray-100">
            <div class="max-w-2xl">
                <header class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 uppercase">General Information</h3>
                    <p class="text-sm text-gray-600">These details are used for clinic registration and contact.</p>
                </header>

                <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-gray-200 p-3 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required autofocus>
                            @error('name') <p class="mt-1 text-xs text-red-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border-gray-200 p-3 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                            @error('email') <p class="mt-1 text-xs text-red-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-xl border-gray-200 p-3 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="+123 456 789">
                            @error('phone') <p class="mt-1 text-xs text-red-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Date of Birth</label>
                            <input type="date"
                                name="date_of_birth"
                                value="{{ old('date_of_birth', $user->date_of_birth instanceof \DateTime ? $user->date_of_birth->format('Y-m-d') : $user->date_of_birth) }}"
                                class="w-full rounded-xl border-gray-200 p-3 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            @error('date_of_birth') <p class="mt-1 text-xs text-red-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Residential Address</label>
                            <textarea name="address" rows="3" class="w-full rounded-xl border-gray-200 p-3 focus:border-blue-500 focus:ring-blue-500 shadow-sm">{{ old('address', $user->address) }}</textarea>
                            @error('address') <p class="mt-1 text-xs text-red-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                            Update Record
                        </button>

                        @if (session('status') === 'profile-updated')
                        <p class="text-sm text-green-600 font-bold uppercase tracking-tighter">Saved!</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-gray-100">
            <div class="max-w-2xl text-gray-800">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div id="delete-account" class="bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-red-50">
            <div class="max-w-2xl text-gray-800">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>
@endsection