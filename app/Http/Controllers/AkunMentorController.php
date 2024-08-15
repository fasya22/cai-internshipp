<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentorModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AkunMentorController extends Controller
{
    public function index()
    {
        $data['user_mntr'] = User::where('role_id', 1)->get();
        // $data['mentor'] = MentorModel::get();
        $data['mentor'] = MentorModel::whereNull('user_id')->get();

        // $data['mntr'] = (object) []; // Initialize $mntr variable as an object

        // // If 'id' parameter is present in the request, fetch the user data for the modal
        // if (request()->has('id')) {
        //     $id = request('id');
        //     $data['mntr'] = User::where('uid', $id)->first();
        // }

        return view('pages.mentor.akunmentor', $data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mentor' => 'required',
            'username' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $mntr = json_decode($request->mentor);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'uid' => Str::uuid(),
            'role_id' => 1,
        ]);

        MentorModel::where('uid', $mntr->uid)->update([
            'user_id' => $user['id']
        ]);

        return redirect('/user-mentor')->with('success', 'Berhasil tambah pengguna');
    }

    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
            ],
            'mentor' => 'required',
            'username' => 'required',
            // 'password' => 'min:8',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->mentor) {
            $mntr = json_decode($request->mentor);

            // Dapatkan pengguna yang akan diperbarui
            $user = User::where('uid', $id)->first();

            // Periksa apakah email yang baru berbeda dari email yang ada
            if ($user->email !== $request->email) {
                // Jika berbeda, atur email_verified_at menjadi null
                $user->email_verified_at = null;
            }

            if ($request->password != null) {
                // Perbarui data user termasuk password
                $user->update([
                    'name' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            } else {
                // Perbarui data user tanpa mengubah password
                $user->update([
                    'name' => $request->username,
                    'email' => $request->email,
                ]);
            }

            return redirect('/user-mentor')->with('success', 'Berhasil update data');
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('uid', $id)->delete();
        return redirect('/user-mentor');
    }
}
