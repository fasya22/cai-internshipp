<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\PosisiModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PosisiController extends Controller
{
    public function index()
    {
        $data['posisi'] = PosisiModel::get();
        return view('pages.posisi.posisi', $data);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'posisi' => 'required',

        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        PosisiModel::create([
            'uid' => Str::uuid(),
            'posisi' => $request->posisi,
        ]);

        return redirect('/posisi')->with('success', 'Berhasil tambah data');
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
            'posisi' => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        PosisiModel::where('uid', $id)->update([
            'posisi' => $request->posisi,
        ]);

        return redirect('/posisi')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PosisiModel::where('uid', $id)->delete();
        return redirect('/posisi');
    }
}
