@extends('layouts.admin')

@section('content')
@php
$roles = [
    'Admin' => ['icon' => 'shield-check', 'color' => 'bg-blue-600'],
    'Guru' => ['icon' => 'user-check', 'color' => 'bg-green-500'],
    'Siswa' => ['icon' => 'graduation-cap', 'color' => 'bg-cyan-500'],
    'Orang Tua' => ['icon' => 'users-round', 'color' => 'bg-orange-500'],
    'Staff' => ['icon' => 'briefcase', 'color' => 'bg-gray-500'],
    'Operator' => ['icon' => 'settings', 'color' => 'bg-purple-500'],
];
$statuses = ['Active', 'Inactive', 'Pending'];
$users = [
    [ 'name' => 'Budi Santoso', 'email' => 'budi@sekolah.id', 'role' => 'Admin', 'status' => 'Active', 'created_at' => '2024-01-10', 'avatar' => 'https://randomuser.me/api/portraits/men/1.jpg' ],
    [ 'name' => 'Siti Aminah', 'email' => 'siti@sekolah.id', 'role' => 'Guru', 'status' => 'Active', 'created_at' => '2024-01-12', 'avatar' => 'https://randomuser.me/api/portraits/women/2.jpg' ],
    [ 'name' => 'Agus Pratama', 'email' => 'agus@sekolah.id', 'role' => 'Siswa', 'status' => 'Pending', 'created_at' => '2024-01-15', 'avatar' => 'https://randomuser.me/api/portraits/men/3.jpg' ],
    [ 'name' => 'Rina Wulandari', 'email' => 'rina@sekolah.id', 'role' => 'Orang Tua', 'status' => 'Inactive', 'created_at' => '2024-01-18', 'avatar' => 'https://randomuser.me/api/portraits/women/4.jpg' ],
    [ 'name' => 'Andi Wijaya', 'email' => 'andi@sekolah.id', 'role' => 'Staff', 'status' => 'Active', 'created_at' => '2024-01-20', 'avatar' => 'https://randomuser.me/api/portraits/men/5.jpg' ],
    [ 'name' => 'Dewi Lestari', 'email' => 'dewi@sekolah.id', 'role' => 'Operator', 'status' => 'Pending', 'created_at' => '2024-01-22', 'avatar' => 'https://randomuser.me/api/portraits/women/6.jpg' ],
    [ 'name' => 'Joko Susilo', 'email' => 'joko@sekolah.id', 'role' => 'Guru', 'status' => 'Inactive', 'created_at' => '2024-01-25', 'avatar' => 'https://randomuser.me/api/portraits/men/7.jpg' ],
    [ 'name' => 'Maya Sari', 'email' => 'maya@sekolah.id', 'role' => 'Siswa', 'status' => 'Active', 'created_at' => '2024-01-28', 'avatar' => 'https://randomuser.me/api/portraits/women/8.jpg' ],
];
$summary = [
    'Total Users' => count($users),
];
foreach ($roles as $role => $info) {
    $summary[$role] = collect($users)->where('role', $role)->count();
}
@endphp

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">User Management</h1>
            <p class="text-gray-500">Kelola dan pantau akun pengguna sistem sekolah</p>
        </div>
        <div class="flex gap-2">
            <button class="flex items-center gap-2 px-5 py-2 border border-gray-300 rounded-full text-gray-700 font-semibold hover:border-blue-500 hover:text-blue-600 transition">
                <i data-lucide="download" class="w-5 h-5"></i>
                Export Users
            </button>
            <button class="flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-full font-bold hover:bg-blue-700 transition">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Add User
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-6 mb-8">
        <div class="flex flex-col items-center rounded-2xl border border-gray-100 p-7 bg-white shadow-lg transition hover:scale-105 hover:shadow-xl duration-200">
            <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-5 w-16 h-16 shadow-md">
                <i data-lucide="users" class="w-8 h-8 text-white"></i>
            </div>
            <span class="text-base font-semibold text-gray-700 mb-2 tracking-wide">Total Users</span>
            <span class="text-4xl font-extrabold text-gray-900 mb-1">{{ $summary['Total Users'] }}</span>
        </div>
        @foreach ($roles as $role => $info)
            <div class="flex flex-col items-center rounded-2xl border border-gray-100 p-7 bg-white shadow-lg transition hover:scale-105 hover:shadow-xl duration-200">
                <div class="bg-gradient-to-br from-white to-{{ str_replace('bg-', '', $info['color']) }}-400 {{ $info['color'] }} rounded-full flex items-center justify-center mb-5 w-16 h-16 shadow-md">
                    <i data-lucide="{{ $info['icon'] }}" class="w-8 h-8 text-white"></i>
                </div>
                <span class="text-base font-semibold text-gray-700 mb-2 tracking-wide">{{ $role }}</span>
                <span class="text-4xl font-extrabold text-gray-900 mb-1">{{ $summary[$role] }}</span>
            </div>
        @endforeach
    </div>

    <!-- Filter & Search -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex gap-2">
            <input type="text" placeholder="Cari nama/email..." class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 focus:outline-none focus:border-blue-500 w-64" id="searchInput">
            <select id="roleFilter" class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 focus:outline-none focus:border-blue-500">
                <option value="">Semua Role</option>
                @foreach(array_keys($roles) as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
            </select>
            <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 focus:outline-none focus:border-blue-500">
                <option value="">Semua Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 bg-gray-100 rounded-xl hover:bg-gray-200">
                <i data-lucide="filter" class="size-5 text-gray-500"></i>
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-x-auto mb-8">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                        <input type="checkbox" class="form-checkbox rounded text-blue-600">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal Dibuat</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100" id="userTableBody">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50 transition" data-role="{{ $user['role'] }}" data-status="{{ $user['status'] }}">
                    <td class="px-6 py-4">
                        <input type="checkbox" class="form-checkbox rounded text-blue-600">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user['avatar'] }}" class="w-10 h-10 rounded-full object-cover border border-gray-200" alt="Avatar">
                            <span class="font-medium text-gray-900">{{ $user['name'] }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user['email'] }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white {{ $roles[$user['role']]['color'] ?? 'bg-gray-400' }}">
                            {{ $user['role'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white
                            @if($user['status'] === 'Active') bg-green-500
                            @elseif($user['status'] === 'Inactive') bg-red-500
                            @else bg-yellow-400 @endif">
                            {{ $user['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user['created_at'] }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <button class="p-2 hover:bg-gray-100 rounded-lg transition" title="View">
                                <i data-lucide="eye" class="w-4 h-4 text-blue-500"></i>
                            </button>
                            <button class="p-2 hover:bg-gray-100 rounded-lg transition" title="Edit">
                                <i data-lucide="edit" class="w-4 h-4 text-gray-500"></i>
                            </button>
                            <button class="p-2 hover:bg-gray-100 rounded-lg transition" title="Delete">
                                <i data-lucide="trash" class="w-4 h-4 text-red-500"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Dummy -->
    <div class="flex items-center justify-between">
        <p class="text-sm text-secondary">Showing 1 to {{ count($users) }} of {{ count($users) }} users</p>
        <div class="flex items-center gap-2">
            <button class="px-3 py-2 border border-border rounded-lg hover:bg-muted">← Previous</button>
            <button class="px-3 py-2 bg-primary text-white rounded-lg">1</button>
            <button class="px-3 py-2 border border-border rounded-lg hover:bg-muted">2</button>
            <button class="px-3 py-2 border border-border rounded-lg hover:bg-muted">3</button>
            <button class="px-3 py-2 border border-border rounded-lg hover:bg-muted">Next →</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    // Filter & Search logic (dummy, client-side)
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const userTableBody = document.getElementById('userTableBody');
    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const role = roleFilter.value;
        const status = statusFilter.value;
        Array.from(userTableBody.children).forEach(row => {
            const name = row.querySelector('span.font-medium').textContent.toLowerCase();
            const email = row.querySelector('td.text-gray-500').textContent.toLowerCase();
            const rowRole = row.getAttribute('data-role');
            const rowStatus = row.getAttribute('data-status');
            let show = true;
            if (search && !(name.includes(search) || email.includes(search))) show = false;
            if (role && rowRole !== role) show = false;
            if (status && rowStatus !== status) show = false;
            row.style.display = show ? '' : 'none';
        });
    }
    searchInput.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
});
</script>
@endsection