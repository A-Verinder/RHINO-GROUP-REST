<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Validation\Rules;
use App\Providers\RouteServiceProvider;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAll();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->only('title', 'first_name', 'last_name', 'middle_name', 'suffex_name', 'username', 'email', 'password', 'type');
        $data['password'] = Hash::make($request->password);
        $this->userService->store($data);

        return redirect(RouteServiceProvider::INDEX);
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
            'title' => 'nullable|in:Mr,Mrs,Ms',
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

        $this->userService->update($user, $data);

        return redirect(RouteServiceProvider::INDEX);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // public function trash()
    // {
    //     $trashedUsers = User::onlyTrashed()->get();
    //     return view('users.trashed', compact('trashedUsers'));
    // }

    public function trashed()
    {
        $trashedUsers = $this->userService->trash();
        return view('users.trashed', ['users' => $trashedUsers]);
    }

    public function restore($id)
    {
        if (!$this->userService->restore($id)) {
            return redirect()->back()->with('error', 'User not found.');
        }
        return redirect()->route('users.trashed')->with('success', 'User restored successfully.');
    }

    public function delete($id)
    {
        if (!$this->userService->forceDelete($id)) {
            return redirect()->back()->with('error', 'User not found.');
        }
        return redirect()->route('users.trashed')->with('success', 'User permanently deleted.');
    }
}

