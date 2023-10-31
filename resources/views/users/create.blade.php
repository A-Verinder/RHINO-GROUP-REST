{{-- resources/views/users/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New User</h1>

    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('users.form')
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection
