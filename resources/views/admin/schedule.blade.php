@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Weekly Doctor Schedules</h2>
            <p class="text-gray-600">Manage recurring slots for clinic operations.</p>
        </div>
        <button onclick="openAddModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-lg">
            + Add Weekly Slot
        </button>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="{{ route('admin.schedules.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Doctor Name</label>
                <select name="doctor_id" class="w-full border border-gray-200 p-2 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $d)
                        <option value="{{ $d->id }}" {{ request('doctor_id') == $d->id ? 'selected' : '' }}>
                            Dr. {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Day of Week</label>
                <select name="day_filter" class="w-full border border-gray-200 p-2 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">All Days</option>
                    <option value="1" {{ request('day_filter') === '1' ? 'selected' : '' }}>Monday</option>
                    <option value="2" {{ request('day_filter') === '2' ? 'selected' : '' }}>Tuesday</option>
                    <option value="3" {{ request('day_filter') === '3' ? 'selected' : '' }}>Wednesday</option>
                    <option value="4" {{ request('day_filter') === '4' ? 'selected' : '' }}>Thursday</option>
                    <option value="5" {{ request('day_filter') === '5' ? 'selected' : '' }}>Friday</option>
                    <option value="6" {{ request('day_filter') === '6' ? 'selected' : '' }}>Saturday</option>
                    <option value="0" {{ request('day_filter') === '0' ? 'selected' : '' }}>Sunday</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="flex-1 bg-gray-800 text-white py-2 rounded-lg hover:bg-black transition text-sm font-bold">
                    Apply Filter
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="flex-1 bg-gray-100 text-gray-600 py-2 rounded-lg text-center text-sm font-bold hover:bg-gray-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b text-gray-500 text-xs uppercase font-bold">
                <tr>
                    <th class="p-4">Doctor</th>
                    <th class="p-4">Recurring Day</th>
                    <th class="p-4">Time Slot</th>
                    <th class="p-4">Max Queue</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($schedules as $s)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="font-bold text-gray-800">Dr. {{ $s->doctor->name }}</div>
                        <div class="text-[10px] text-blue-600 font-bold uppercase">{{ $s->doctor->specialty }}</div>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">
                            {{ $s->day_full_name }}
                        </span>
                    </td>
                    <td class="p-4 text-sm text-gray-600">
                        {{ $s->start_time_12h }} - {{ $s->end_time_12h }}
                    </td>
                    <td class="p-4 text-sm text-gray-500">{{ $s->max_queue }} patients</td>
                    <td class="p-4 text-right flex justify-end space-x-4">
                        <button onclick="openEditModal(this)"
                            data-id="{{ $s->id }}"
                            data-doctor="{{ $s->doctor_id }}"
                            data-day="{{ $s->date }}"
                            data-start="{{ $s->start_time }}"
                            data-end="{{ $s->end_time }}"
                            data-max="{{ $s->max_queue }}"
                            class="text-blue-600 hover:text-blue-800 font-bold text-sm">Edit</button>

                        <form action="{{ route('admin.schedules.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Delete this schedule?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-400">
                        No schedules found matching the criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="scheduleModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white p-8 rounded-2xl w-full max-w-md shadow-2xl">
        <h3 id="modalTitle" class="text-xl font-bold mb-6 text-gray-800">Weekly Schedule</h3>
        <form id="scheduleForm" method="POST">
            @csrf
            <div id="methodField"></div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Doctor</label>
                    <select name="doctor_id" id="form_doctor" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        @foreach($doctors as $d) <option value="{{ $d->id }}">Dr. {{ $d->name }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Day of the Week</label>
                    <select name="date" id="form_day" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="0">Sunday</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">Start Time</label>
                        <input type="time" name="start_time" id="form_start" class="w-full border border-gray-300 p-2 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">End Time</label>
                        <input type="time" name="end_time" id="form_end" class="w-full border border-gray-300 p-2 rounded-lg" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Max Queue Size</label>
                    <input type="number" name="max_queue" id="form_max" placeholder="e.g. 20" class="w-full border border-gray-300 p-2 rounded-lg" required>
                </div>
            </div>
            <div class="mt-8 flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-500 font-bold">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg font-bold shadow-lg shadow-blue-100">Save Schedule</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('scheduleModal');
    const form = document.getElementById('scheduleForm');

    function openAddModal() {
        form.reset();
        form.action = "{{ route('admin.schedules.store') }}";
        document.getElementById('methodField').innerHTML = "";
        document.getElementById('modalTitle').innerText = "Add Weekly Slot";
        modal.classList.replace('hidden', 'flex');
    }

    function openEditModal(btn) {
        document.getElementById('form_doctor').value = btn.dataset.doctor;
        document.getElementById('form_day').value = btn.dataset.day;
        document.getElementById('form_start').value = btn.dataset.start;
        document.getElementById('form_end').value = btn.dataset.end;
        document.getElementById('form_max').value = btn.dataset.max;

        form.action = "/admin/schedules/" + btn.dataset.id;
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        document.getElementById('modalTitle').innerText = "Edit Weekly Slot";
        modal.classList.replace('hidden', 'flex');
    }

    function closeModal() {
        modal.classList.replace('flex', 'hidden');
    }
</script>
@endsection