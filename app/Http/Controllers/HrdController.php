<?php

namespace App\Http\Controllers;

use App\Models\HrdModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class HrdController extends Controller
{
    public function index()
    {
        $data['hrd'] = HrdModel::get();
        return view('pages.hrd.hrd', $data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'level' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:8',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);


        // Response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Cek apakah ada file foto yang diunggah
        if ($request->hasFile('foto')) {
            $name = $request->file('foto')->getClientOriginalName();
            $filename = time() . '-' . $name;
            $file = $request->file('foto');
            $file->storeAs('public/images', $filename);

            // Simpan data User terlebih dahulu
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'uid' => Str::uuid(),
                'role_id' => 3,
            ]);

            // Simpan data HrdModel dengan user_id yang baru dibuat
            HrdModel::create([
                'uid' => Str::uuid(),
                'user_id' => $user->id,
                'level' => $request->level,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'image' => $filename,
            ]);

            return redirect('/hrd')->with('success', 'Berhasil tambah data');
        } else {
            // Simpan data User terlebih dahulu
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'uid' => Str::uuid(),
                'role_id' => 3,
            ]);

            // Simpan data HrdModel dengan user_id yang baru dibuat
            HrdModel::create([
                'uid' => Str::uuid(),
                'user_id' => $user->id,
                'level' => $request->level,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            return redirect('/hrd')->with('success', 'Berhasil tambah data');
        }
    }

    public function show(string $uid)
    {
        $user = User::where('uid', $uid)->first();
        $hrd = HrdModel::where('user_id', $user->id)->first();

        return view('pages.hrd.profilhrd', compact('user', 'hrd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uid)
    {
        $user = User::where('uid', $uid)->first();
        $hrd = HrdModel::where('user_id', $user->id)->first();

        return view('pages.hrd.edit_profil_hrd', compact('user', 'hrd'));
    }

    public function updateProfil(Request $request, $uid)
    {
        $request->validate([
            'nama' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($uid, 'uid')],
            'jenis_kelamin' => 'nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = User::where('uid', $uid)->firstOrFail();
        if ($user->email !== $request->email) {
            $user->update([
                'email' => $request->email,
                'email_verified_at' => null,
            ]);
        }

        $hrd = HrdModel::where('user_id', $user->id)->firstOrFail();
        $hrd->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Upload dan simpan gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);

            // Simpan hanya nama file di dalam database
            $hrd->update([
                'image' => $imageName,
            ]);
        }

        return redirect()->route('profil-hrd.show', $uid)->with('success', 'Profil berhasil diperbarui');
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'nama' => 'required',
        'jenis_kelamin' => 'required',
        'level' => 'required',
        'email' => [
            'required',
            'email',
        ],
        'password' => 'nullable|min:8',
        'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Response error validation
    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator)->withInput();
    }

    // Temukan hrd yang akan diupdate
    $hrd = HrdModel::where('uid', $id)->firstOrFail();

    // Update data user terkait
    $user = User::where('id', $hrd->user_id)->firstOrFail();

    // Check if email has changed
    if ($user->email !== $request->email) {
        // Validate email uniqueness
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,' . $user->id,
        ]);

        // Response error validation if email is not unique
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Set email_verified_at to null if email is changed
        $user->email_verified_at = null;
    }

    // Update user name and email
    $user->update([
        'name' => $request->nama,
        'email' => $request->email,
    ]);

    // Update hrd data
    $hrd->update([
        'nama' => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'level' => $request->level,
    ]);

    // Update password if provided
    if ($request->filled('password')) {
        $user->update([
            'password' => Hash::make($request->password),
        ]);
    }

    // Upload and save photo if provided
    if ($request->hasFile('foto')) {
        $name = $request->file('foto')->getClientOriginalName();
        $filename = time() . '-' . $name;

        // Simpan file ke storage
        $path = $request->file('foto')->storeAs('public/images', $filename);

        // Hapus foto lama jika ada dan simpan yang baru
        if ($hrd->image) {
            Storage::delete('public/images/' . $hrd->image);
        }

        // Simpan hanya nama file di dalam database
        $hrd->update([
            'image' => $filename,
        ]);
    }

    return redirect('/hrd')->with('success', 'Berhasil edit data');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hrd = HrdModel::where('uid', $id)->first();

        if ($hrd) {
            // Hapus user terkait jika ada
            if ($hrd->user) {
                $hrd->user->delete();
            }

            // Soft delete data mentor
            $hrd->delete();
        }
        return redirect('/hrd');
    }
}
