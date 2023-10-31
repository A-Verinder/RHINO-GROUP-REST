{{-- resources/views/users/form.blade.php --}}

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <select name="title" class="form-control">
        <option value="Mr" {{ old('title', $user->title ?? '') == 'Mr' ? 'selected' : '' }}>Mr</option>
        <option value="Mrs" {{ old('title', $user->title ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
        <option value="Ms" {{ old('title', $user->title ?? '') == 'Ms' ? 'selected' : '' }}>Ms</option>
    </select>
</div>

<div class="mb-3">
    <label for="first_name" class="form-label">First Name</label>
    <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}">
</div>

<div class="mb-3">
    <label for="last_name" class="form-label">Last Name</label>
    <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}">
</div>

<div class="mb-3">
    <label for="middle_name" class="form-label">Middle Name</label>
    <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $user->middle_name ?? '') }}">
</div>

<div class="mb-3">
    <label for="suffex_name" class="form-label">Suffex Name</label>
    <input type="text" class="form-control" name="suffex_name" value="{{ old('suffex_name', $user->suffex_name ?? '') }}">
</div>

<div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" value="{{ old('username', $user->username ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email ?? '') }}">
</div>

<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password">
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" name="password_confirmation">
</div>


<div class="mb-3">
    <label for="photo" class="form-label">Photo</label>
    <input type="file" class="form-control" name="photo">
</div>

<div class="mb-3">
    <label for="type" class="form-label">Type</label>
    <input type="text" class="form-control" name="type">
</div>
