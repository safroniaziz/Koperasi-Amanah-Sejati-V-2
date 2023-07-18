<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    public function index(){
        $anggotas = User::orderBy('created_at','desc')->get();
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
            'jabatan_id'            => 'required',
            'nama_lengkap'          => 'required',
            'nik'                   => 'required|numeric|unique:users,nik',
            'tahun_keanggotaan'     => 'required|digits:4|numeric|min:1000|max:9999',
            'alamat'                => 'required',
            'email'                 => 'required|email|unique:users,email',
            'image_path'            => 'image|mimes:png,jpg,jpeg|max:1000',
            'password'              => 'required|confirmed',
        ], [
            'jabatan_id.required'           => 'Kolom Jabatan harus diisi.',
            'nama_lengkap.required'         => 'Kolom Nama Lengkap harus diisi.',
            'nik.required'                  => 'Kolom NIK harus diisi.',
            'nik.numeric'                   => 'Kolom NIK harus berupa angka.',
            'nik.unique'                    => 'NIK sudah digunakan.',
            'tahun_keanggotaan.required'    => 'Kolom Tahun Keanggotaan harus diisi.',
            'tahun_keanggotaan.digits'      => 'Kolom Tahun Keanggotaan harus berisi 4 digit.',
            'tahun_keanggotaan.numeric'     => 'Kolom Tahun Keanggotaan harus berupa angka.',
            'tahun_keanggotaan.min'         => 'Kolom Tahun Keanggotaan minimal 4 digit.',
            'tahun_keanggotaan.max'         => 'Kolom Tahun Keanggotaan maksimal 4 digit.',
            'alamat.required'               => 'Kolom Alamat harus diisi.',
            'email.required'                => 'Kolom Email harus diisi.',
            'email.email'                   => 'Format Email tidak valid.',
            'email.unique'                  => 'Email sudah digunakan.',
            'image_path.image'              => 'File yang diunggah harus berupa gambar.',
            'image_path.mimes'              => 'Format file gambar harus PNG, JPG, atau JPEG.',
            'image_path.max'                => 'Ukuran file gambar maksimal 1000 KB (1 MB).',
            'password.required'             => 'Kolom Password harus diisi.',
            'password.confirmed'            => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $uniqueName = null;
        $file = $request->file('image_path');
        if ($file) {
            $uniqueName = $request->nik.Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_anggota/', $uniqueName);
        }

        $simpan = User::create([
            'jabatan_id'            =>  $request->jabatan_id,
            'nama_lengkap'          =>  $request->nama_lengkap,
            'nik'                   =>  $request->nik,
            'alamat'                =>  $request->alamat,
            'tahun_keanggotaan'     =>  $request->tahun_keanggotaan,
            'simpanan_pokok'        =>  500000,
            'email'                 =>  $request->email,
            'password'              =>  bcrypt($request->password),
            'image_path'            =>  $uniqueName,
            'is_active'             =>  1,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, data anggota berhasil disimpan',
                'url'   =>  url('/anggota/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, data anggota gagal disimpan']);
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
                'text'  =>  'Yeay, data anggota berhasil diubah',
                'url'   =>  url('/anggota/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, data anggota gagal diubah']);
        }
    }
}
