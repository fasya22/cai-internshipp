<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HrdModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AkunHrdController extends Controller
{
    public function index()
    {
        $data['user_hrd'] = User::where('role_id', 3)->get();
        // $data['hrd'] = HrdModel::get();
        $data['hrd'] = HrdModel::whereNull('user_id')->get();
        // $data['hrd'] = (object) []; // Initialize $hrd variable as an object

        // // If 'id' parameter is present in the request, fetch the user data for the modal
        // if (request()->has('id')) {
        //     $id = request('id');
        //     $data['hrd'] = User::where('uid', $id)->first();
        // }

        return view('pages.hrd.akunhrd', $data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hrd' => 'required',
            'username' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $hrd = json_decode($request->hrd);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'uid' => Str::uuid(),
            'role_id' => 3,
        ]);

        HrdModel::where('uid', $hrd->uid)->update([
            'user_id' => $user['id']
        ]);

        return redirect('/user-hrd')->with('success', 'Berhasil tambah pengguna');
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
            'hrd' => 'required',
            'username' => 'required',
            // 'password' => 'min:8',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hrd) {
            $hrdd = json_decode($request->hrd);

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

            return redirect('/user-hrd')->with('success', 'Berhasil update data');
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
        return redirect('/user-hrd');
    }
}
