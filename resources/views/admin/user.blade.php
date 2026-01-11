@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Users & Admins</h2>
            <p class="text-gray-600">Manage user accounts and permissions</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Search User</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Name, email, or phone..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <i class="ri-search-line absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <div class="w-full md:w-48">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Role</label>
                <select name="role" class="w-full border border-gray-300 py-2 px-3 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Roles</option>
                    <option value="1" {{ request('role') === '1' ? 'selected' : '' }}>Admin</option>
                    <option value="0" {{ request('role') === '0' ? 'selected' : '' }}>Regular User</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-bold transition">
                    Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-lg hover:bg-gray-200 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Contact</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center mr-3 text-indigo-600 font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">#{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $user->email }}</p>
                            <p class="text-xs text-gray-500">{{ $user->phone ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role == 1)
                            <span class="px-3 py-1 text-[10px] font-black uppercase bg-purple-100 text-purple-700 rounded-full border border-purple-200">Admin</span>
                            @else
                            <span class="px-3 py-1 text-[10px] font-black uppercase bg-gray-100 text-gray-600 rounded-full border border-gray-200">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-3">
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.' . ($user->role == 1 ? 'demote' : 'promote'), $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold {{ $user->role == 1 ? 'text-blue-600' : 'text-purple-600' }} hover:underline">
                                        {{ $user->role == 1 ? 'Make User' : 'Make Admin' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm font-bold text-red-600 hover:underline">Delete</button>
                                </form>
                                @else
                                <span class="text-sm text-gray-400 italic">You</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">No users found matching your criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>


<script>
    // JavaScript search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearchBtn');
        const userRows = document.querySelectorAll('.user-row');
        const noUsersRow = document.getElementById('noUsersRow');

        // Add input event listener for search
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();

            // Show/hide clear button
            if (searchTerm) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            let foundAny = false;

            // Search through each user row
            userRows.forEach(row => {
                const searchData = row.getAttribute('data-search');
                const rowText = row.textContent.toLowerCase();

                // Check if search term exists in data-search attribute or row text
                if (searchData.includes(searchTerm) || rowText.includes(searchTerm)) {
                    row.style.display = '';
                    foundAny = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Handle empty results
            if (searchTerm && !foundAny) {
                // Hide original "no users" row if it exists
                if (noUsersRow) {
                    noUsersRow.style.display = 'none';
                }

                // Show "no results" message
                let noResultsRow = document.getElementById('noResultsRow');
                if (!noResultsRow) {
                    noResultsRow = document.createElement('tr');
                    noResultsRow.id = 'noResultsRow';
                    noResultsRow.innerHTML = `
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        No users found matching "<span class="font-semibold">${searchTerm}</span>"
                    </td>
                `;
                    document.querySelector('#usersTableBody').appendChild(noResultsRow);
                } else {
                    noResultsRow.style.display = '';
                }
            } else {
                // Remove "no results" row if exists
                const noResultsRow = document.getElementById('noResultsRow');
                if (noResultsRow) {
                    noResultsRow.style.display = 'none';
                }

                // Show original "no users" row if no users exist
                if (noUsersRow && userRows.length === 0) {
                    noUsersRow.style.display = '';
                }
            }
        });

        // Clear search
        window.clearSearch = function() {
            searchInput.value = '';
            clearBtn.classList.add('hidden');

            // Show all rows
            userRows.forEach(row => {
                row.style.display = '';
            });

            // Remove "no results" row if exists
            const noResultsRow = document.getElementById('noResultsRow');
            if (noResultsRow) {
                noResultsRow.style.display = 'none';
            }

            // Show original "no users" row if no users exist
            if (noUsersRow && userRows.length === 0) {
                noUsersRow.style.display = '';
            }
        };

        // Optional: Add debounce for better performance
        let searchTimeout;
        const originalInputHandler = searchInput.oninput;
        searchInput.oninput = function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                originalInputHandler.call(this);
            }, 300);
        };
    });
</script>
@endsection