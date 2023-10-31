{{-- resources/views/users/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Users</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New User</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->title }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="post" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
