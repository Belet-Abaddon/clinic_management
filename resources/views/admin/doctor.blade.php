@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Doctors Management</h2>
            <p class="text-gray-600 mb-4">Manage doctors data.</p>
            <div class="mt-2 relative">
                <input type="text" id="searchInput" placeholder="Search doctors..."
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-72 focus:ring-2 focus:ring-blue-500">
                <i class="ri-search-line absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
        <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="ri-user-add-line mr-2"></i> Add Doctor
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif

    <div id="doctorsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($doctors as $doctor)
        <div class="doctor-card bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <i class="ri-user-line text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 doctor-name">Dr. {{ $doctor->name }}</h3>
                        <p class="text-sm text-gray-600 doctor-specialty">{{ $doctor->specialty }}</p>
                    </div>
                </div>

                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600"><i class="ri-delete-bin-line"></i></button>
                </form>
            </div>

            <p class="text-sm text-gray-600 ">{{ $doctor->phone ?? 'No phone' }}</p>
            <p class="text-sm text-gray-600 doctor-description mb-4">{{ $doctor->description ?? 'No description' }}</p>

            <button
                onclick="openEditModal(this)"
                data-id="{{ $doctor->id }}"
                data-name="{{ $doctor->name }}"
                data-specialty="{{ $doctor->specialty }}"
                data-phone="{{ $doctor->phone }}"
                data-description="{{ $doctor->description }}"
                class="w-full py-2 bg-gray-50 text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-100">
                Edit Doctor
            </button>
        </div>
        @endforeach
    </div>
</div>

<div id="doctorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <h3 id="modalTitle" class="text-xl font-bold mb-4">Add Doctor</h3>
        <form id="doctorForm" method="POST">
            @csrf
            <div id="putMethod"></div>
            <div class="space-y-4">
                <input type="text" name="name" id="field_name" placeholder="Full Name" required class="w-full px-4 py-2 border rounded-lg">
                <select name="specialty" id="field_specialty" required class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Select Specialty</option>
                    <option value="Cardiology">Cardiology</option>
                    <option value="Neurology">Neurology</option>
                    <option value="Pediatrics">Pediatrics</option>
                    <option value="Orthopedics">Orthopedics</option>
                    <option value="Dermatology">Dermatology</option>
                    <option value="Ophthalmology">Ophthalmology</option>
                    <option value="General Medicine">General Medicine</option>
                    <option value="Surgery">Surgery</option>
                    <option value="Gynecology">Gynecology</option>
                    <option value="Psychiatry">Psychiatry</option>
                </select>
                <input type="text" name="phone" id="field_phone" placeholder="Phone" class="w-full px-4 py-2 border rounded-lg">
                <textarea name="description" id="field_description" placeholder="Description" class="w-full px-4 py-2 border rounded-lg"></textarea>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. JavaScript Search (DOM-based)
    document.getElementById('searchInput').addEventListener('input', function() {
        const term = this.value.toLowerCase();
        const cards = document.querySelectorAll('.doctor-card');

        cards.forEach(card => {
            const name = card.querySelector('.doctor-name').textContent.toLowerCase();
            const specialty = card.querySelector('.doctor-specialty').textContent.toLowerCase();

            if (name.includes(term) || specialty.includes(term)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    const modal = document.getElementById('doctorModal');
    const form = document.getElementById('doctorForm');

    // 2. Open Modal for Add
    function openAddModal() {
        form.reset();
        form.action = "{{ route('admin.doctors.store') }}";
        document.getElementById('putMethod').innerHTML = '';
        document.getElementById('modalTitle').innerText = 'Add Doctor';
        modal.classList.replace('hidden', 'flex');
    }

    // 3. Open Modal for Edit (Pulls from button attributes)
    function openEditModal(btn) {
        const id = btn.getAttribute('data-id');
        document.getElementById('field_name').value = btn.getAttribute('data-name');
        document.getElementById('field_specialty').value = btn.getAttribute('data-specialty');
        document.getElementById('field_phone').value = btn.getAttribute('data-phone');
        document.getElementById('field_description').value = btn.getAttribute('data-description');

        form.action = `/admin/doctors/${id}`;
        document.getElementById('putMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('modalTitle').innerText = 'Edit Doctor';
        modal.classList.replace('hidden', 'flex');
    }

    function closeModal() {
        modal.classList.replace('flex', 'hidden');
    }
</script>
@endsection