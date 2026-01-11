@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-bold text-2xl text-gray-800">My Medical Appointments</h2>
            <a href="{{ route('doctors.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Book New</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-gray-500 text-sm font-medium uppercase">Total Bookings</p>
                <p class="text-3xl font-black text-slate-900">{{ $total }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-gray-500 text-sm font-medium uppercase">Active/Pending</p>
                <p class="text-3xl font-black text-blue-600">{{ $upcoming }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-gray-500 text-sm font-medium uppercase">Finished Visits</p>
                <p class="text-3xl font-black text-green-600">{{ $completed }}</p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-3xl overflow-hidden border border-gray-100">
            @forelse($appointments as $appt)
                <div class="p-6 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center font-bold text-xl">
                                {{ substr($appt->schedule->doctor->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Dr. {{ $appt->schedule->doctor->name }}</h3>
                                <p class="text-blue-600 text-sm font-semibold uppercase">{{ $appt->schedule->doctor->specialization }}</p>
                                
                                <div class="mt-2 space-y-1 text-sm text-gray-500">
                                    <p><span class="font-medium text-gray-700">Date:</span> {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</p>
                                    <p><span class="font-medium text-gray-700">Time:</span> {{ $appt->schedule->start_time }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-3">
                            <div class="text-right">
                                <span class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Queue Number</span>
                                <span class="inline-block bg-slate-900 text-white text-lg font-black px-4 py-1 rounded-xl">
                                    #{{ str_pad($appt->queue_number, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                @if($appt->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase">Pending</span>
                                    <form action="{{ route('appointments.cancel', $appt->id) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold underline">Cancel</button>
                                    </form>
                                @elseif($appt->status == 'on_service')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase">In Room</span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Completed</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <p class="text-gray-400">You have no appointments yet.</p>
                    <a href="{{ route('doctors.index') }}" class="text-blue-600 font-bold underline mt-2 inline-block">Book your first visit</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection