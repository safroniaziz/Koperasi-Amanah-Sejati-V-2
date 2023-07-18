<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TransaksiKoperasi;
use Illuminate\Support\Facades\Validator;


class TransaksiKoperasiController extends Controller
{
    public function index()
    {
        $transaksiKoperasis = TransaksiKoperasi::all();
        return view('backend/transaksiKoperasi.index', [
            'transaksiKoperasis'  =>  $transaksiKoperasis,
        ]);
    }

    public function create()
    {
        $anggotas = User::all();
        return view('backend/transaksiKoperasi.create', [
            'anggotas'   =>  $anggotas,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id'            => 'required',
            'jumlah_transaksi'      => 'required|numeric',
            'tanggal_transaksi'     => 'required|numeric|max:31',
            'bulan_transaksi'       => 'required|numeric|digits:2',
            'tahun_transaksi'       => 'required|numeric|digits:4|min:1000|max:9999',
            'angsuran_ke'           => 'required|numeric',
        ], [
            'anggota_id.required'           => 'Kolom Anggota harus diisi.',
            'jumlah_transaksi.required'     => 'Kolom Jumlah Transaksi harus diisi.',
            'jumlah_transaksi.numeric'      => 'Kolom Jumlah Transaksi harus berupa angka.',
            'tanggal_transaksi.required'    => 'Kolom Tanggal Transaksi harus diisi.',
            'tanggal_transaksi.numeric'     => 'Kolom Tanggal Transaksi harus berupa angka.',
            'tanggal_transaksi.max'         => 'Kolom Tanggal Transaksi harus memiliki nilai maksimal 31.',
            'bulan_transaksi.required'      => 'Kolom Bulan Transaksi harus diisi.',
            'bulan_transaksi.numeric'       => 'Kolom Bulan Transaksi harus berupa angka.',
            'bulan_transaksi.digits'        => 'Kolom Bulan Transaksi harus terdiri dari 2 digit.',
            'tahun_transaksi.required'      => 'Kolom Tahun Transaksi harus diisi.',
            'tahun_transaksi.numeric'       => 'Kolom Tahun Transaksi harus berupa angka.',
            'tahun_transaksi.digits'        => 'Kolom Tahun Transaksi harus terdiri dari 4 digit.',
            'tahun_transaksi.min'           => 'Kolom Tahun Transaksi harus memiliki nilai minimal 1000.',
            'tahun_transaksi.max'           => 'Kolom Tahun Transaksi harus memiliki nilai maksimal 9999.',
            'angsuran_ke.required'          => 'Kolom Angsuran Ke harus diisi.',
            'angsuran_ke.numeric'            => 'Kolom Angsuran Ke harus berupa numeric.',
        ]);




        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $simpan = TransaksiKoperasi::create([
            'jenis_transaksi_id'    =>  1,
            'anggota_id'            =>  $request->anggota_id,
            'jumlah_transaksi'      =>  $request->jumlah_transaksi,
            'tanggal_transaksi'     =>  $request->tanggal_transaksi,
            'bulan_transaksi'       =>  $request->bulan_transaksi,
            'tahun_transaksi'       =>  $request->tahun_transaksi,
            'angsuran_ke'           =>  $request->angsuran_ke,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, transaksi koperasi baru berhasil disimpan',
                'url'   =>  url('/transaksiKoperasi/'),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, transaksi koperasi gagal disimpan']);
        }
    }

    public function edit(TransaksiKoperasi $transaksiKoperasi)
    {
        return $transaksiKoperasi;
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

        $transaksiKoperasi = TransaksiKoperasi::findOrFail($request->simpanan_wajib_id);

        $update = $transaksiKoperasi->update([
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
