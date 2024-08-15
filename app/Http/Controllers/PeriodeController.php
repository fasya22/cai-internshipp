<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\PeriodeModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PeriodeController extends Controller
{
    public function index()
    {
        $data['periode'] = PeriodeModel::get();
        return view('pages.periode.periode', $data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|after_or_equal:batas_pendaftaran',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'batas_pendaftaran' => 'required|before_or_equal:tanggal_mulai',
            // 'tgl_pengumuman' => 'required|after_or_equal:batas_pendaftaran|before_or_equal:tanggal_mulai',
        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        PeriodeModel::create([
            'uid' => Str::uuid(),
            'judul_periode' => $request->judul_periode,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'batas_pendaftaran' => $request->batas_pendaftaran,
            // 'tgl_pengumuman' => $request->tgl_pengumuman,
        ]);

        return redirect('/periode')->with('success', 'Berhasil tambah data');
    }

    public function show($id)
    {
        //
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
            'judul_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|after_or_equal:batas_pendaftaran',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'batas_pendaftaran' => 'required|before_or_equal:tanggal_mulai',
            // 'tgl_pengumuman' => 'required|date|after_or_equal:batas_pendaftaran|before_or_equal:tanggal_mulai',
        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        PeriodeModel::where('uid', $id)->update([
            'judul_periode' => $request->judul_periode,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'batas_pendaftaran' => $request->batas_pendaftaran,
            // 'tgl_pengumuman' => $request->tgl_pengumuman,
        ]);

        return redirect('/periode')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PeriodeModel::where('uid', $id)->delete();
        return redirect('/periode');
    }
}
