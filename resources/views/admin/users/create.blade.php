@extends('admin.layouts.app')

@section('title', 'Add User')

@section('content')
<h1 class="mb-4">Add New User</h1>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="driver">Driver</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection
