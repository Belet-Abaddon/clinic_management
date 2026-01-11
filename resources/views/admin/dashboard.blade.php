@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Appointments</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($totalAppointments) }}</p>
                    <p class="text-xs {{ $growth >= 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                        <i class="{{ $growth >= 0 ? 'ri-arrow-up-line' : 'ri-arrow-down-line' }}"></i>
                        {{ number_format(abs($growth), 1) }}% from last month
                    </p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="ri-calendar-check-line text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Doctors</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $activeDoctors }}</p>
                    <p class="text-xs text-gray-500">Available</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <i class="ri-user-star-line text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Appointments</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $pendingCount }}</p>
                    <p class="text-xs text-yellow-500">
                        <i class="ri-alert-line"></i> Needs attention
                    </p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <i class="ri-time-line text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Appointments</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $todayCount }}</p>
                    <p class="text-xs text-blue-500">Scheduled today</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i class="ri-calendar-line text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.appointments.index') }}" class="bg-white rounded-xl border border-gray-200 p-6 hover:border-blue-300 hover:bg-blue-50 transition-all">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                    <i class="ri-calendar-check-line text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Take Appointment</h3>
                    <p class="text-sm text-gray-500">For walk-in patients</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.doctors.index') }}" class="bg-white rounded-xl border border-gray-200 p-6 hover:border-green-300 hover:bg-green-50 transition-all">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                    <i class="ri-user-add-line text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Add Doctor</h3>
                    <p class="text-sm text-gray-500">Register new doctor</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="bg-white rounded-xl border border-gray-200 p-6 hover:border-purple-300 hover:bg-purple-50 transition-all">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center mr-4">
                    <i class="ri-history-line text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Manage Schedules</h3>
                    <p class="text-sm text-gray-500">Set doctor availability</p>
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Administrator List</h3>
                <i class="ri-shield-user-line text-gray-400"></i>
            </div>
            <div class="space-y-4">
                @forelse($admins as $admin)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3 text-indigo-600 font-bold">
                            {{ substr($admin->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $admin->name }}</p>
                            <p class="text-xs text-gray-500">{{ $admin->email }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full font-bold uppercase">Admin</span>
                </div>
                @empty
                <p class="text-center text-gray-400 py-4">No admins found.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Doctor List</h3>
                <i class="ri-nurse-line text-gray-400"></i>
            </div>
            <div class="space-y-4">
                @forelse($doctorList as $doc)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-600">
                            <i class="ri-user-add-line"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">Dr. {{ $doc->name }}</p>
                            <p class="text-xs text-gray-500">{{ $doc->specialization ?? 'General Physician' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] bg-green-50 text-green-600 px-2 py-1 rounded-full font-bold uppercase">Active</span>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 py-4">No doctors registered.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection