<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf
                        
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <select name="title" class="form-control">
            <option value="Mr" {{ old('title', $user->title ?? '') == 'Mr' ? 'selected' : '' }}>Mr</option>
            <option value="Mrs" {{ old('title', $user->title ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
            <option value="Ms" {{ old('title', $user->title ?? '') == 'Ms' ? 'selected' : '' }}>Ms</option>
        </select>
    </div>
    
    <div>
        <x-input-label for="first_name" :value="__('First name')" />
        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $user->first_name ?? '')" required autofocus autocomplete="first_name" />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="last_name" :value="__('Last name')" />
        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="middle_name" :value="__('Middle name')" />
        <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')" />
    </div>

    <div>
        <x-input-label for="suffex_name" :value="__('Suffex name')" />
        <x-text-input id="suffex_name" class="block mt-1 w-full" type="text" name="suffex_name" :value="old('suffex_name')"  />
    </div>

    <div class="mt-4">
        <x-input-label for="username" :value="__('Username')" />
        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" 
                required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>


    <div class="mb-3">
        <label for="photo" class="form-label">Photo</label>
        <input type="file" class="form-control" name="photo">
    </div>

    <div class="mt-4">
        <x-input-label for="type" :value="__('Type')" />
        <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type')" />
    </div>

    <x-primary-button class="ml-4">
        {{ __('Create User') }}
    </x-primary-button>

    </form>
</x-app-layout>
