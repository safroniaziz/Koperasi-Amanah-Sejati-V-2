<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PinjamanController extends Controller
{
    public function index()
    {
        $pinjamans = Pinjaman::all();
        return view('backend/pinjaman.index', [
            'pinjamans'  =>  $pinjamans,
        ]);
    }

    public function create()
    {
        $anggotas = User::all();
        return view('backend/pinjaman.create', [
            'anggotas'   =>  $anggotas,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id'                => 'required',
            'jumlah_transaksi'          => 'required|numeric',
            'presentase_jasa'           => 'required|numeric',
            'angsuran_pokok'            => 'required|numeric',
            'angsuran_jasa'             => 'required|numeric',
            'jumlah_bulan'              => 'required|numeric',
            'bulan_mulai_angsuran'      => 'required|numeric|digits:2',
            'tahun_mulai_angsuran'      => 'required|numeric|digits:4|min:1000|max:9999',
            'bulan_selesai_angsuran'    => 'required|numeric|digits:2',
            'tahun_selesai_angsuran'    => 'required|numeric|digits:4|min:1000|max:9999',
            'pinjaman_ke'               => 'required|numeric',
        ], [
            'anggota_id.required'               => 'Kolom Anggota harus diisi.',
            'jumlah_transaksi.required'         => 'Kolom Jumlah Transaksi harus diisi.',
            'jumlah_transaksi.numeric'          => 'Kolom Jumlah Transaksi harus berupa angka.',
            'presentase_jasa.required'          => 'Kolom Presentase Jasa harus diisi.',
            'presentase_jasa.numeric'           => 'Kolom Presentase Jasa harus berupa angka.',
            'angsuran_pokok.required'            => 'Kolom Angsuran Pokok harus diisi.',
            'angsuran_pokok.numeric'             => 'Kolom Angsuran Pokok harus berupa angka.',
            'angsuran_jasa.required'             => 'Kolom Angsuran Jasa harus diisi.',
            'angsuran_jasa.numeric'              => 'Kolom Angsuran Jasa harus berupa angka.',
            'jumlah_bulan.required'              => 'Kolom Jumlah Bulan harus diisi.',
            'jumlah_bulan.numeric'               => 'Kolom Jumlah Bulan harus berupa angka.',
            'bulan_mulai_angsuran.required'      => 'Kolom Bulan Mulai Angsuran harus diisi.',
            'bulan_mulai_angsuran.numeric'       => 'Kolom Bulan Mulai Angsuran harus berupa angka.',
            'bulan_mulai_angsuran.digits'        => 'Kolom Bulan Mulai Angsuran harus terdiri dari 2 digit angka.',
            'tahun_mulai_angsuran.required'      => 'Kolom Tahun Mulai Angsuran harus diisi.',
            'tahun_mulai_angsuran.numeric'       => 'Kolom Tahun Mulai Angsuran harus berupa angka.',
            'tahun_mulai_angsuran.digits'        => 'Kolom Tahun Mulai Angsuran harus terdiri dari 4 digit angka.',
            'tahun_mulai_angsuran.min'           => 'Kolom Tahun Mulai Angsuran harus memiliki nilai minimal 1000.',
            'tahun_mulai_angsuran.max'           => 'Kolom Tahun Mulai Angsuran harus memiliki nilai maksimal 9999.',
            'bulan_selesai_angsuran.required'    => 'Kolom Bulan Selesai Angsuran harus diisi.',
            'bulan_selesai_angsuran.numeric'     => 'Kolom Bulan Selesai Angsuran harus berupa angka.',
            'bulan_selesai_angsuran.digits'      => 'Kolom Bulan Selesai Angsuran harus terdiri dari 2 digit angka.',
            'tahun_selesai_angsuran.required'    => 'Kolom Tahun Selesai Angsuran harus diisi.',
            'tahun_selesai_angsuran.numeric'     => 'Kolom Tahun Selesai Angsuran harus berupa angka.',
            'tahun_selesai_angsuran.digits'      => 'Kolom Tahun Selesai Angsuran harus terdiri dari 4 digit angka.',
            'tahun_selesai_angsuran.min'         => 'Kolom Tahun Selesai Angsuran harus memiliki nilai minimal 1000.',
            'tahun_selesai_angsuran.max'         => 'Kolom Tahun Selesai Angsuran harus memiliki nilai maksimal 9999.',
            'pinjaman_ke.required'               => 'Kolom Pinjaman Ke harus diisi.',
            'pinjaman_ke.numeric'                => 'Kolom Pinjaman Ke harus berupa angka.',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $simpan = Pinjaman::create([
            'jenis_transaksi_id'        =>  1,
            'anggota_id'                =>  $request->anggota_id,
            'jumlah_transaksi'          =>  $request->jumlah_transaksi,
            'presentase_jasa'           =>  $request->presentase_jasa,
            'angsuran_pokok'            =>  $request->angsuran_pokok,
            'angsuran_jasa'             =>  $request->angsuran_jasa,
            'jumlah_bulan'              =>  $request->jumlah_bulan,
            'bulan_mulai_angsuran'      =>  $request->bulan_mulai_angsuran,
            'tahun_mulai_angsuran'      =>  $request->tahun_mulai_angsuran,
            'bulan_selesai_angsuran'    =>  $request->bulan_selesai_angsuran,
            'tahun_selesai_angsuran'    =>  $request->tahun_selesai_angsuran,
            'pinjaman_ke'               =>  $request->pinjaman_ke,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, pinjaman baru berhasil disimpan',
                'url'   =>  url('/pinjaman/'),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, pinjaman gagal disimpan']);
        }
    }

    public function edit(Pinjaman $pinjaman)
    {
        return $pinjaman;
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

        $pinjaman = Pinjaman::findOrFail($request->simpanan_wajib_id);

        $update = $pinjaman->update([
            'nama_jenis_transaksi'  =>  $request->nama_jenis_transaksi,
            'kategori_transaksi'  =>  $request->kategori_transaksi,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, pinjaman berhasil diubah',
                'url'   =>  url('/pinjaman/'),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, pinjaman gagal diubah']);
        }
    }
}
