<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaModel;
// use App\Models\MentorModel;
use App\Models\User;
use Carbon\Carbon;
// use App\Models\Master\PosisiModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data['peserta'] = PesertaModel::whereHas('user', function ($query) {
        //     $query->where('role_id', 2);
        // })->get();
        $user = Auth::user();

        if ($user->role_id == 1) {
            // Jika user memiliki role mentor
            $data['peserta'] = PesertaModel::where('mentor_id', $user->mentor->id)->get();
        } else {
            // Jika user bukan mentor, tampilkan semua data peserta
            $data['peserta'] = PesertaModel::get();
        }

        // $data['posisi'] = PosisiModel::get();
        // $data['mentor'] = MentorModel::get();
        return view('pages.peserta.peserta', $data);
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
        $validator = Validator::make($request->all(), [
            'nama',
            'jenis_kelamin',
            'alamat',
            // 'posisi',
            // 'mentor',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        // Cek apakah ada file foto yang diunggah
        if ($request->hasFile('foto')) {
            $name = $request->file('foto')->getClientOriginalName();
            $filename = time() . '-' . $name;
            $file = $request->file('foto');
            $file->move(public_path('Image'), $filename);

            $user = User::find(Auth::id());

            PesertaModel::create([
                'uid' => Str::uuid(),
                'nama' => $user->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                // 'posisi_id' => $request->posisi,
                // 'mentor_id' => $request->mentor,
                'image' => $filename,
            ]);
            return redirect('/peserta')->with('success', 'Berhasil tambah data');
        } else {

            $user = User::find(Auth::id());
            PesertaModel::create([
                'uid' => Str::uuid(),
                'nama' => $user->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                // 'posisi_id' => $request->posisi,
                // 'mentor_id' => $request->mentor,
            ]);
        }
        return redirect('/peserta')->with('success', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uid)
    {
        $user = User::where('uid', $uid)->first();
        $peserta = PesertaModel::where('user_id', $user->id)->first();
        // $peserta->tanggal_mulai_studi_formatted = Carbon::parse($peserta->tanggal_mulai_studi)->translatedFormat('j F Y');
        // $peserta->tanggal_berakhir_studi_formatted = Carbon::parse($peserta->tanggal_berakhir_studi)->translatedFormat('j F Y');


        return view('pages.peserta.profilpeserta', compact('user', 'peserta'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uid)
    {
        $user = User::where('uid', $uid)->first();
        $peserta = PesertaModel::where('user_id', $user->id)->first();

        return view('pages.peserta.edit_profil_peserta', compact('user', 'peserta'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uid)
    {
        $request->validate([
            'nama' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($uid, 'uid')],
            'alamat' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'no_hp' => 'nullable',
            'pendidikan_terakhir' => 'nullable',
            'institusi_pendidikan_terakhir' => 'nullable',
            'prodi' => 'nullable',
            'ipk' => 'nullable|numeric|between:0,4.00',
            'institusi_pendidikan_terakhir' => 'nullable',
            'tanggal_mulai_studi' => 'nullable|date',
            'tanggal_berakhir_studi' => 'nullable|date',
            'kartu_identitas_studi' => 'file|mimes:pdf|max:2048',
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

        $peserta = PesertaModel::where('user_id', $user->id)->firstOrFail();
        $peserta->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'institusi_pendidikan_terakhir' => $request->institusi_pendidikan_terakhir,
            'prodi' => $request->prodi,
            'ipk' => $request->ipk,
            'tanggal_mulai_studi' => $request->tanggal_mulai_studi,
            'tanggal_berakhir_studi' => $request->tanggal_berakhir_studi,
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
            $peserta->update([
                'image' => $imageName,
            ]);
        }


        // Upload dan simpan kartu identitas studi jika ada
        if ($request->hasFile('kartu_identitas_studi')) {
            $kartuIdentitas = $request->file('kartu_identitas_studi');
            $kartuIdentitasName = time() . '-' . $kartuIdentitas->getClientOriginalName();
            $kartuIdentitas->storeAs('public/kartu_identitas_studi', $kartuIdentitasName);

            // Simpan hanya nama file di dalam database
            $peserta->update([
                'kartu_identitas_studi' => $kartuIdentitasName,
            ]);
        }

        return redirect()->route('profil-peserta.show', $uid)->with('success', 'Profil berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PesertaModel::where('uid', $id)->delete();
        return redirect('/peserta');
    }
}
