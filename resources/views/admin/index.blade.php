@extends('layouts.app')

@section('content')
    <div class="p-6 bg-grey rounded shadow">
        <h2 class="text-xl font-bold mb-4">Users</h2>

        <form method="GET" class="mb-4">
        </form>
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Role</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">{{ $user->role }}</td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <select name="role" onchange="this.form.submit()"
                                    class="w-full bg-white border-2 border-gray-300 rounded-lg px-3 py-2
                   text-gray-700 font-medium
                   focus:outline-none focus:ring-2 focus:ring-blue-500
                   focus:border-blue-500 cursor-pointer shadow-sm">

                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                                        👤 User
                                    </option>

                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                        🛡 Admin
                                    </option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
