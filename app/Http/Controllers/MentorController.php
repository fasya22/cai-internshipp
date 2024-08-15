<?php

namespace App\Http\Controllers;

use App\Exports\MentorExport;
use App\Models\Master\PeriodeModel;
use Illuminate\Http\Request;
use App\Models\MentorModel;
use App\Models\Master\PosisiModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class MentorController extends Controller
{
    public function index(Request $request)
{
    $query = MentorModel::query();

    if ($request->filled('posisi')) {
        $query->where('posisi_id', $request->posisi);
    }

    if ($request->filled('periode')) {
        $query->whereHas('magang', function ($q) use ($request) {
            $q->whereHas('lowongan', function ($q2) use ($request) {
                $q2->whereHas('periode', function ($q3) use ($request) {
                    $q3->where('id', $request->periode);
                });
            });
        });
    }


    if ($request->filled('level')) {
        $query->where('level', $request->level);
    }

    $data['mentor'] = $query->get();
    $data['posisi'] = PosisiModel::get();
    $mentorIds = $data['mentor']->pluck('id');
    $data['periode'] = PeriodeModel::whereHas('lowongans', function ($query) use ($mentorIds) {
        $query->whereHas('magang', function ($q) use ($mentorIds) {
            $q->whereIn('mentor_id', $mentorIds);
        });
    })->get();

    return view('pages.mentor.mentor', $data);
}


    public function create()
    {
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'posisi',
    //         'nama' => 'required',
    //         'jenis_kelamin' => 'required',
    //         'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     // Response error validation
    //     if ($validator->fails()) {
    //         return Redirect::back()->withErrors($validator);
    //     }

    //     // Cek apakah ada file foto yang diunggah
    //     if ($request->hasFile('foto')) {
    //         $name = $request->file('foto')->getClientOriginalName();
    //         $filename = time() . '-' . $name;
    //         $file = $request->file('foto');
    //         $file->move(public_path('Images'), $filename);

    //         MentorModel::create([
    //             'uid' => Str::uuid(),
    //             'posisi_id' => $request->posisi,
    //             'nama' => $request->nama,
    //             'jenis_kelamin' => $request->jenis_kelamin,
    //             'image' => $filename,
    //         ]);
    //     return redirect('/mentor')->with('success', 'Berhasil tambah data');
    //     } else {
    //         MentorModel::create([
    //             'uid' => Str::uuid(),
    //             'posisi_id' => $request->posisi,
    //             'nama' => $request->nama,
    //             'jenis_kelamin' => $request->jenis_kelamin,
    //         ]);
    //     }

    //     return redirect('/mentor')->with('success', 'Berhasil tambah data');

    // }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'posisi' => 'required',
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
                'role_id' => 1,
            ]);

            // Simpan data MentorModel dengan user_id yang baru dibuat
            MentorModel::create([
                'uid' => Str::uuid(),
                'user_id' => $user->id,
                'posisi_id' => $request->posisi,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'level' => $request->level,
                'image' => $filename,
            ]);

            return redirect('/mentor')->with('success', 'Berhasil tambah data');
        } else {
            // Simpan data User terlebih dahulu
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'uid' => Str::uuid(),
                'role_id' => 1,
            ]);

            // Simpan data MentorModel dengan user_id yang baru dibuat
            MentorModel::create([
                'uid' => Str::uuid(),
                'user_id' => $user->id,
                'posisi_id' => $request->posisi,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'level' => $request->level,
            ]);

            return redirect('/mentor')->with('success', 'Berhasil tambah data');
        }
    }


    public function show(string $uid)
    {
        $user = User::where('uid', $uid)->first();
        $mentor = MentorModel::where('user_id', $user->id)->first();

        return view('pages.mentor.profilmentor', compact('user', 'mentor'));
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
        $mentor = MentorModel::where('user_id', $user->id)->first();

        return view('pages.mentor.edit_profil_mentor', compact('user', 'mentor'));
    }

    public function updateProfil(Request $request, $uid)
    {
        $request->validate([
            'nama' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($uid, 'uid')],
            // 'posisi' => 'nullable',
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

        $mentor = MentorModel::where('user_id', $user->id)->firstOrFail();
        $mentor->update([
            'nama' => $request->nama,
            // 'posisi_id' => $request->posisi,
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
            $mentor->update([
                'image' => $imageName,
            ]);
        }


        return redirect()->route('profil-mentor.show', $uid)->with('success', 'Profil berhasil diperbarui');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'posisi' => 'required',
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

        // Temukan mentor yang akan diupdate
        $mentor = MentorModel::where('uid', $id)->firstOrFail();

        // Update data user terkait
        $user = User::where('id', $mentor->user_id)->firstOrFail();

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

        // Update mentor data
        $mentor->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'posisi_id' => $request->posisi,
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
            if ($mentor->image) {
                Storage::delete('public/images/' . $mentor->image);
            }

            // Simpan hanya nama file di dalam database
            $mentor->update([
                'image' => $filename,
            ]);
        }

        return redirect('/mentor')->with('success', 'Berhasil edit data');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mentor = MentorModel::where('uid', $id)->first();

        if ($mentor) {
            // Hapus user terkait jika ada
            if ($mentor->user) {
                $mentor->user->delete();
            }

            // Soft delete data mentor
            $mentor->delete();
        }
        return redirect('/mentor');
    }

    // public function exportExcel()
    // {
    //     return Excel::download(new MentorExport, 'data_mentor.xlsx');
    // }
}
