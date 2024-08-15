<?php

namespace App\Http\Controllers;

use App\Models\Master\AspekModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AspekPenilaianController extends Controller
{
    public function index()
    {
        $aspekList = AspekModel::get();
        $totalExistingBobot = AspekModel::sum('bobot');
        $maxBobot = 100 - $totalExistingBobot;

        // Hitung total bobot yang sudah digunakan
        $totalUsedBobot = $totalExistingBobot;

        // Cek apakah total bobot sudah mencapai 100%
        $isBobotFull = $totalUsedBobot == 100;

        $data['aspek'] = $aspekList;
        $data['maxBobot'] = $maxBobot;
        $data['isBobotFull'] = $isBobotFull;

        // Calculate maxBobotUpdate for each aspek
        foreach ($aspekList as $aspek) {
            $totalExistingBobotUpdate = AspekModel::where('uid', '!=', $aspek->uid)->sum('bobot');
            $aspek->maxBobotUpdate = 100 - $totalExistingBobotUpdate;
        }
        return view('pages.penilaian.aspekpenilaian', $data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        // Hitung total bobot yang sudah ada dalam tabel
        $totalExistingBobot = AspekModel::sum('bobot');

        // Tentukan batas maksimal bobot yang diinginkan
        $maxBobot = 100 - $totalExistingBobot;

        // Lakukan validasi
        $validator = Validator::make($request->all(), [
            'aspek' => 'required',
            'bobot' => ['required', 'numeric', 'max:' . $maxBobot],
        ]);

        // Response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        // Simpan data jika validasi berhasil
        AspekModel::create([
            'uid' => Str::uuid(),
            'aspek' => $request->aspek,
            'bobot' => $request->bobot,
        ]);

        return redirect('/aspek-penilaian')->with('success', 'Berhasil tambah data');
    }


    public function show($id)
    {
        // $data['aspek'] = AspekModel::where('uid', $id)->first();
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
        $currentAspek = AspekModel::where('uid', $id)->first();
        if (!$currentAspek) {
            return redirect('/aspek-penilaian')->with('error', 'Data tidak ditemukan');
        }

        $totalExistingBobotUpdate = AspekModel::where('uid', '!=', $id)->sum('bobot');
        $maxBobotUpdate = 100 - $totalExistingBobotUpdate + $currentAspek->bobot;

        $validator = Validator::make($request->all(), [
            'aspek' => 'required',
            'bobot' => ['required', 'numeric', 'min:1', 'max:' . $maxBobotUpdate],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        AspekModel::where('uid', $id)->update([
            'aspek' => $request->aspek,
            'bobot' => $request->bobot,
        ]);

        return redirect('/aspek-penilaian')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AspekModel::where('uid', $id)->delete();
        return redirect('/aspek-penilaian');
    }
}
