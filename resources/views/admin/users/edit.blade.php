@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<h1 class="mb-4">Edit User</h1>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div class="form-group">
        <label for="password">Password (leave blank to keep current password)</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
            <option value="driver" {{ $user->role == 'driver' ? 'selected' : '' }}>Driver</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
