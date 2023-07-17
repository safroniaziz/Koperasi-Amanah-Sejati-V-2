<?php

namespace App\Http\Controllers;

use App\Models\JenisTransaksi;
use App\Models\SimpananWajib;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SimpananWajibController extends Controller
{
    public function index(){
        $simpananWajibs = SimpananWajib::all();
        return view('backend/simpananWajib.index',[
            'simpananWajibs'  =>  $simpananWajibs,
        ]);
    }

    public function create(){
        $jenisTransaksis = JenisTransaksi::all();
        return view('backend/simpananWajib.create',[
            'jenisTransaksis'   =>  $jenisTransaksis,
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

        $simpan = SimpananWajib::create([
            'nama_jenis_transaksi'  =>  $request->nama_jenis_transaksi,
            'kategori_transaksi'  =>  $request->kategori_transaksi,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, simpanan wajib baru berhasil disimpan',
                'url'   =>  url('/simpanan_wajib/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, simpanan wajib gagal disimpan']);
        }
    }

    public function edit(SimpananWajib $simpananWajib){
        return $simpananWajib;
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

        $simpananWajib = SimpananWajib::findOrFail($request->simpanan_wajib_id);

        $update = $simpananWajib->update([
            'nama_jenis_transaksi'  =>  $request->nama_jenis_transaksi,
            'kategori_transaksi'  =>  $request->kategori_transaksi,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, simpanan wajib berhasil diubah',
                'url'   =>  url('/simpanan_wajib/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, simpanan wajib gagal diubah']);
        }
    }
}
