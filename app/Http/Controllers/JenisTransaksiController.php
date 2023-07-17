<?php

namespace App\Http\Controllers;

use App\Models\JenisTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisTransaksiController extends Controller
{
    public function index(){
        $jenisTransaksis = JenisTransaksi::all();
        return view('backend/jenisTransaksi.index',[
            'jenisTransaksis'  =>  $jenisTransaksis,
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

        $simpan = JenisTransaksi::create([
            'nama_jenis_transaksi'  =>  $request->nama_jenis_transaksi,
            'kategori_transaksi'  =>  $request->kategori_transaksi,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, jenis transaksi baru berhasil disimpan',
                'url'   =>  url('/jenis_transaksi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jenis transaksi gagal disimpan']);
        }
    }

    public function edit(JenisTransaksi $jenisTransaksi){
        return $jenisTransaksi;
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

        $jenisTransaksi = JenisTransaksi::findOrFail($request->jenis_transaksi_id);

        $update = $jenisTransaksi->update([
            'nama_jenis_transaksi'  =>  $request->nama_jenis_transaksi,
            'kategori_transaksi'  =>  $request->kategori_transaksi,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, jenis transaksi berhasil diubah',
                'url'   =>  url('/jenis_transaksi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jenis transaksi gagal diubah']);
        }
    }

    public function delete(JenisTransaksi $jenisTransaksi){
        $delete = $jenisTransaksi->delete();

        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, jenis transaksi berhasil dihapus',
                'url'   =>  url('/jenis_transaksi/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, jenis transaksi gagal dihapus']);
        }
    }
}
