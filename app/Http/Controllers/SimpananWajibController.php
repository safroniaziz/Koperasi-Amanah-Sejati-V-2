<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SimpananWajib;
use App\Models\JenisTransaksi;
use Illuminate\Support\Facades\Validator;

class SimpananWajibController extends Controller
{
    public function index()
    {
        $simpananWajibs = SimpananWajib::all();
        return view('backend/simpananWajib.index', [
            'simpananWajibs'  =>  $simpananWajibs,
        ]);
    }

    public function create()
    {
        $anggotas = User::all();
        return view('backend/simpananWajib.create', [
            'anggotas'   =>  $anggotas,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id'            => 'required',
            'tanggal_transaksi'     => 'required|numeric',
            'bulan_transaksi'       => 'required|numeric|digits:2',
            'tahun_transaksi'       => 'required|numeric|digits:4|min:1000|max:9999',
        ], [
            'anggota_id.required'   => 'Kolom Anggota harus diisi.',
            'tanggal_transaksi.required' => 'Kolom Tanggal Transaksi harus diisi.',
            'tanggal_transaksi.numeric' => 'Kolom Tanggal Transaksi harus berupa angka.',
            'bulan_transaksi.required' => 'Kolom Bulan Transaksi harus diisi.',
            'bulan_transaksi.numeric' => 'Kolom Bulan Transaksi harus berupa angka.',
            'bulan_transaksi.digits' => 'Kolom Bulan Transaksi harus terdiri dari 2 digit angka.',
            'tahun_transaksi.required' => 'Kolom Tahun Transaksi harus diisi.',
            'tahun_transaksi.numeric' => 'Kolom Tahun Transaksi harus berupa angka.',
            'tahun_transaksi.digits' => 'Kolom Tahun Transaksi harus terdiri dari 4 digit angka.',
            'tahun_transaksi.min' => 'Kolom Tahun Transaksi harus memiliki nilai minimal 1000.',
            'tahun_transaksi.max' => 'Kolom Tahun Transaksi harus memiliki nilai maksimal 9999.',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $simpan = SimpananWajib::create([
            'jenis_transaksi_id'    =>  1,
            'anggota_id'            =>  $request->anggota_id,
            'tanggal_transaksi' =>  $request->tanggal_transaksi,
            'bulan_transaksi'   =>  $request->bulan_transaksi,
            'tahun_transaksi'   =>  $request->tahun_transaksi,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, simpanan wajib baru berhasil disimpan',
                'url'   =>  url('/simpanan_wajib/'),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, simpanan wajib gagal disimpan']);
        }
    }

    public function edit(SimpananWajib $simpananWajib)
    {
        return $simpananWajib;
    }

    public function update(Request $request)
    {
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
        } else {
            return response()->json(['text' =>  'Oopps, simpanan wajib gagal diubah']);
        }
    }
}
