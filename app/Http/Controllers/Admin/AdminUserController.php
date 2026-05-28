<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{
    /**
     * Display a listing of user accounts.
     */
    public function index()
    {
        Gate::authorize('super-admin-only');

        $users = User::orderBy('name', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Store a newly created user in database.
     */
    public function store(Request $request)
    {
        Gate::authorize('super-admin-only');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,editor',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'নতুন ইউজার অ্যাকাউন্ট সফলভাবে তৈরি করা হয়েছে।');
    }

    /**
     * Update the specified user's role and details.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('super-admin-only');

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:super_admin,admin,editor',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'ইউজার অ্যাকাউন্টের বিবরণ সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Remove the specified user account.
     */
    public function destroy($id)
    {
        Gate::authorize('super-admin-only');

        $user = User::findOrFail($id);

        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'আপনি নিজের অ্যাকাউন্ট মুছে ফেলতে পারবেন না!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'ইউজার অ্যাকাউন্ট সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
