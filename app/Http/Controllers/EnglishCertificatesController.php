<?php

namespace App\Http\Controllers;

use App\Models\EnglishCertificatesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EnglishCertificatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['english_certificates'] = EnglishCertificatesModel::get();
        return view('pages.jenis_sertifikat.jenis_sertifikat', $data);
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
            'jenis_sertifikat' => 'required',
            'nilai_minimum' => 'required',

        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        EnglishCertificatesModel::create([
            'uid' => Str::uuid(),
            'jenis_sertifikat' => $request->jenis_sertifikat,
            'nilai_minimum' => $request->nilai_minimum,
        ]);

        return redirect('/english-certificates')->with('success', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_sertifikat' => 'required',
            'nilai_minimum' => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        EnglishCertificatesModel::where('uid', $id)->update([
            'jenis_sertifikat' => $request->jenis_sertifikat,
            'nilai_minimum' => $request->nilai_minimum,
        ]);

        return redirect('/english-certificates')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        EnglishCertificatesModel::where('uid', $id)->delete();
        return redirect('/english-certificates');
    }
}
