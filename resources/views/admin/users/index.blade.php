@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
<h1 class="mb-4">Users</h1>
<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add New User</a>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
