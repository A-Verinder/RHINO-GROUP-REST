<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|in:Mr,Mrs,Ms',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffex_name' => 'nullable|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048',
            'type' => 'nullable|string|max:255',
        ]);

        $data = $request->only('title', 'first_name', 'last_name', 'middle_name', 'suffex_name', 'username', 'email', 'password', 'type');
        $data['password'] = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('user_photos', 'public');
            $data['photo'] = $photoPath;
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'title' => 'required|in:Mr,Mrs,Ms',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffex_name' => 'nullable|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048',
            'type' => 'nullable|string|max:255',
        ]);

        $data = $request->only('title', 'first_name', 'last_name', 'middle_name', 'suffex_name', 'username', 'email', 'password', 'type');
        $data['password'] = Hash::make($request->password);
        
        
        if($request->has('password') && $request->password) {
            $data['password'] = Hash::make($request->password);
        }
        
        if($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('user_photos', 'public');
            $data['photo'] = $photoPath;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function trash()
    {
        $trashedUsers = User::onlyTrashed()->get();
        return view('users.trashed', compact('trashedUsers'));
    }

    public function trashed()
    {
        $trashedUsers = User::onlyTrashed()->get();
        return view('users.trashed', ['users' => $trashedUsers]);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $user->restore();
        return redirect()->route('users.trashed')->with('success', 'User restored successfully.');
    }

    public function delete($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $user->forceDelete();
        return redirect()->route('users.trashed')->with('success', 'User permanently deleted.');
    }
}

