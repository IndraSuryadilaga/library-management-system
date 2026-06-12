<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::filter($request->only(['search', 'role']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        // Define filter configurations
        $userFilters = [
            [
                'name' => 'role',
                'label' => 'Role',
                'placeholder' => 'Semua Role',
                'options' => ['admin' => 'Admin', 'user' => 'User'],
                'value' => $request->query('role')
            ],
        ];

        return view('pages.admin.users.index', compact('users', 'userFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userFields = [
            ['name' => 'name', 'label' => 'Nama', 'value' => old('name'), 'required' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => old('email'), 'required' => true],
            ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'required' => true],
            ['name' => 'password_confirmation', 'label' => 'Konfirmasi Password', 'type' => 'password', 'required' => true],
            ['name' => 'role', 'label' => 'Role', 'type' => 'select', 'options' => ['admin' => 'Admin', 'user' => 'User'], 'value' => old('role'), 'required' => true],
        ];

        return view('pages.admin.users.create', compact('userFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userDetails = [
            ['label' => 'ID Pengguna', 'value' => $user->id, 'isMono' => true],
            ['label' => 'Nama', 'value' => $user->name],
            ['label' => 'Email', 'value' => $user->email],
            ['label' => 'Role', 'value' => $user->role],
            ['label' => 'Dibuat pada', 'value' => $user->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $user->updated_at->format('d F Y')],
        ];

        return view('pages.admin.users.show', compact('user', 'userDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $userFields = [
            ['name' => 'name', 'label' => 'Nama', 'value' => old('name', $user->name), 'required' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => old('email', $user->email), 'required' => true],
            ['name' => 'password', 'label' => 'Password Baru (Opsional)', 'type' => 'password'],
            ['name' => 'password_confirmation', 'label' => 'Konfirmasi Password Baru', 'type' => 'password'],
            ['name' => 'role', 'label' => 'Role', 'type' => 'select', 'options' => ['admin' => 'Admin', 'user' => 'User'], 'value' => old('role', $user->role), 'required' => true],
        ];

        return view('pages.admin.users.edit', compact('user', 'userFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'],
        ]);

        $data = $request->only('name', 'email', 'role');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
