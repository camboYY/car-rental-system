<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,staff,user',
            'password' => 'required|min:8',
        ]);

        User::create([
            ...$data,
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->back()->with('success', 'User created');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$user->id",
            'role' => 'required|in:admin,staff,user',
        ]);

        $user->update($data);

        return redirect()->back()->with('success', 'User updated');
    }

    public function toggle(User $user)
    {
        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return redirect()->back()->with('success', 'User status updated');
    }
}
