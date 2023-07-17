<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    public function index(){
        $anggotas = User::all();
        return view('backend/anggota.index',[
            'anggotas'  =>  $anggotas,
        ]);
    }

    public function create(){
        $jabatans = Jabatan::all();
        return view('backend/anggota.create',[
            'jabatans'   =>  $jabatans,
        ]);
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_jenis_transaksi' => 'required|string',
            'kategori_transaksi'    =>  'required',
        ], [
            'nama_jenis_transaksi.required' => 'Kolom Jenis Transaksi Harus Diisi.',
            'kategori_transaksi.required' => 'Kolom Kategori Transaksi Harus Diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $simpan = User::create([
            'nama_jenis_transaksi'  =>  $request->nama_jenis_transaksi,
            'kategori_transaksi'  =>  $request->kategori_transaksi,
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

    public function edit(User $anggota){
        return $anggota;
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_jenis_transaksi' => 'required|string',
            'kategori_transaksi'    =>  'required',
        ], [
            'nama_jenis_transaksi.required' => 'Kolom Jenis Transaksi Harus Diisi.',
            'kategori_transaksi.required' => 'Kolom Kategori Transaksi Harus Diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $anggota = User::findOrFail($request->anggota_id);

        $update = $anggota->update([
            'nama_jenis_transaksi'  =>  $request->nama_jenis_transaksi,
            'kategori_transaksi'  =>  $request->kategori_transaksi,
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
}
