{{-- resources/views/users/edit.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('users.form')
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
