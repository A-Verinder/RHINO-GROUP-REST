{{-- resources/views/users/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->fullname }}</h1>
    <p><strong>Title:</strong> {{ $user->title }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}'s photo">
    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Back to list</a>
</div>
@endsection
