@extends('layouts.app')

@section('content')
@php
$dayNames = [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
@endphp

<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        <h1 class="text-3xl font-bold mb-8 text-gray-800">Book an Appointment</h1>
        <div class="mb-10 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <form action="{{ route('doctors.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Doctor Name</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search..."
                        class="w-full rounded-2xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 p-3">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Category</label>
                    <select name="specialty" class="w-full rounded-2xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 p-3">
                        <option value="">All Specialties</option>
                        @foreach($specialties as $specialty)
                        <option value="{{ $specialty }}" {{ request('specialty') == $specialty ? 'selected' : '' }}>
                            {{ $specialty }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-2xl transition shadow-lg shadow-blue-100">
                        Apply Filters
                    </button>
                </div>

            </form>

            @if(request('specialty') || request('search'))
            <div class="mt-4 text-center">
                <a href="{{ route('doctors.index') }}" class="text-sm text-gray-400 hover:text-blue-600 underline">Clear all filters</a>
            </div>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($doctors as $doctor)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Dr. {{ $doctor->name }}</h3>
                    <p class="text-blue-600 font-medium">{{ $doctor->specialty }}</p>
                </div>

                <div class="space-y-3">
                    <p class="text-xs font-semibold text-gray-400 uppercase">Weekly Schedule</p>
                    @foreach($doctor->schedules as $schedule)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="text-sm text-gray-700">
                            <p class="font-bold">{{ $dayNames[$schedule->date] }}</p>
                            <p class="text-xs text-gray-500">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                        </div>
                        <button type="button"
                            class="book-btn bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-700 transition"
                            data-doctor-name="{{ $doctor->name }}"
                            data-schedule-id="{{ $schedule->id }}"
                            data-day-index="{{ $schedule->date }}">
                            Book
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-8 shadow-2xl">
        <h2 class="text-2xl font-bold mb-4">Confirm Details</h2>

        <div id="bookingSummary" class="mb-6 p-4 bg-blue-50 rounded-2xl border border-blue-100 text-blue-800 text-sm">
        </div>

        <form action="{{ route('doctors.book') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="schedule_id" id="modal_schedule_id">
            <input type="hidden" name="appointment_date" id="modal_appointment_date">

            <div class="grid grid-cols-1 gap-4">
                <input type="text" name="name" value="{{ auth()->user()->name }}" placeholder="Patient Name" required class="w-full rounded-xl border-gray-200 p-3">
                <div class="flex gap-4">
                    <input type="number" name="age" placeholder="Age" required class="w-full rounded-xl border-gray-200 p-3">
                    <input type="text" name="phone" placeholder="Phone Number" required class="w-full rounded-xl border-gray-200 p-3">
                </div>
                <input type="email" name="email" value="{{ auth()->user()->email }}" placeholder="Email Address" required class="w-full rounded-xl border-gray-200 p-3">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-3 text-gray-500 font-bold">Cancel</button>
                <button type="submit" class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200">Confirm Book</button>
            </div>
        </form>
    </div>
</div>

<script>
    const dayMap = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

    document.querySelectorAll('.book-btn').forEach(button => {
        button.addEventListener('click', function() {
            const drName = this.getAttribute('data-doctor-name');
            const scheduleId = this.getAttribute('data-schedule-id');
            const dayIdx = parseInt(this.getAttribute('data-day-index'));

            // Calculate next date for that day index
            const today = new Date();
            let apptDate = new Date();
            let diff = (dayIdx - today.getDay() + 7) % 7;
            if (diff === 0) diff = 7;
            apptDate.setDate(today.getDate() + diff);

            const dateStr = apptDate.toISOString().split('T')[0];

            // Fill Form
            document.getElementById('modal_schedule_id').value = scheduleId;
            document.getElementById('modal_appointment_date').value = dateStr;
            document.getElementById('bookingSummary').innerHTML = `
                <p><strong>Doctor:</strong> Dr. ${drName}</p>
                <p><strong>Date:</strong> ${dayMap[dayIdx]}, ${dateStr}</p>
            `;

            document.getElementById('bookingModal').classList.remove('hidden');
        });
    });

    function closeModal() {
        document.getElementById('bookingModal').classList.add('hidden');
    }
</script>
@endsection