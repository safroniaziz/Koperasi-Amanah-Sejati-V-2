<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function index(){
        $jabatans = Jabatan::all();
        return view('backend/jabatan.index',[
            'jabatans'  =>  $jabatans,
        ]);
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'required|string',
        ], [
            'nama_jabatan.required' => 'Kolom Nama Jabatan Harus Diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $simpan = Jabatan::create([
            'nama_jabatan'  =>  $request->nama_jabatan,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, jabatan baru berhasil disimpan',
                'url'   =>  url('/jabatan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jabatan gagal disimpan']);
        }
    }

    public function edit(Jabatan $jabatan){
        return $jabatan;
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'required|string',
        ], [
            'nama_jabatan.required' => 'Kolom Nama Jabatan Harus Diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $jabatan = Jabatan::findOrFail($request->jabatan_id);

        $update = $jabatan->update([
            'nama_jabatan'  =>  $request->nama_jabatan,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, jabatan berhasil diubah',
                'url'   =>  url('/jabatan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jabatan gagal diubah']);
        }
    }

    public function delete(Jabatan $jabatan){
        $delete = $jabatan->delete();

        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, jabatan berhasil dihapus',
                'url'   =>  url('/jabatan/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jabatan gagal dihapus']);
        }
    }
}
