<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource (Admin only)
     */
    public function index()
    {
        $this->requireAdmin();

        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource (Admin only)
     */
    public function create()
    {
        $this->requireAdmin();

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage (Admin only)
     */
    public function store(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'   => 'required|in:active,inactive',
            'role'     => 'required|in:admin,user',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($validated);

        return redirect()->route('users.index')->with([
            'message'    => 'User created successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Display the specified resource (Admin only)
     */
    public function show(User $user)
    {
        $this->requireAdmin();

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource (Admin only)
     */
    public function edit(User $user)
    {
        $this->requireAdmin();

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage (Admin only)
     */
    public function update(Request $request, User $user)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'   => 'required|in:active,inactive',
            'role'     => 'required|in:admin,user',
        ]);

        // Handle password update
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('users.index')->with([
            'message'    => 'User updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage (Admin only)
     */
    public function destroy(User $user)
    {
        $this->requireAdmin();

        // Prevent deleting the last admin
        if ($user->isAdmin() && User::where('role', 'admin')->count() === 1) {
            return back()->with([
                'message'    => 'Cannot delete the last admin user',
                'alert-type' => 'error',
            ]);
        }

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::delete('public/' . $user->avatar);
        }

        $user->delete();

        return redirect()->route('users.index')->with([
            'message'    => 'User deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Toggle user status (Admin only)
     */
    public function toggleStatus(User $user)
    {
        $this->requireAdmin();

        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return back()->with([
            'message'    => 'User status updated successfully',
            'alert-type' => 'success',
        ]);
    }
}
