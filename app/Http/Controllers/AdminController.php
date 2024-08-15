<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uid)
    {
        $user = User::where('uid', $uid)->first();

        return view('pages.admin.profiladmin', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uid)
    {
        $user = User::where('uid', $uid)->first();

        // Pastikan bahwa user adalah admin
        if ($user->role_id !== 0) {
            return redirect()->back()->with('error', 'Akun bukan admin.');
        }

        return view('pages.admin.edit_profil_admin', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uid)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($uid, 'uid')],
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = User::where('uid', $uid)->firstOrFail();
        if ($user->email !== $request->email) {
            $user->update([
                'email' => $request->email,
                'email_verified_at' => null,
            ]);
        }

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('profil-admin.show', $uid)->with('success', 'Profil berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
