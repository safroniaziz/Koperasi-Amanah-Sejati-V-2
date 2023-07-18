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
            'jabatan_id'            =>  'required',
            'nama_lengkap'          =>  'required',
            'nik'                   =>  'required',
            'tahun_keanggotaan'     =>  'required',
            'alamat'                =>  'required',
            'email'                 =>  'required|email|unique:users,email',
            'foto'                  =>  'required|image|mimes:png,jpg,jpeg|max:1000',
            'passowrd'              =>  'required',
        ], [
            'jabatan_id.required'           => 'Kolom Jabatan harus diisi.',
            'nama_lengkap.required'         => 'Kolom Nama Lengkap harus diisi.',
            'nik.required'                  => 'Kolom NIK harus diisi.',
            'tahun_keanggotaan.required'    => 'Kolom Tahun Keanggotaan harus diisi.',
            'alamat.required'               => 'Kolom Alamat harus diisi.',
            'email.required'                => 'Kolom Email harus diisi.',
            'email.email'                   => 'Format Email tidak valid.',
            'email.unique'                  => 'Email sudah digunakan.',
            'foto.required'                 => 'Kolom Foto harus diisi.',
            'foto.image'                    => 'File yang diunggah harus berupa gambar.',
            'foto.mimes'                    => 'Format file gambar harus PNG, JPG, atau JPEG.',
            'foto.max'                      => 'Ukuran file gambar maksimal 1000 KB (1 MB).',
            'password.required'             => 'Kolom Password harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $file = $request->file('image_path');
        $uniqueName = null;
        if ($file) {
            $uniqueName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        }

        $path = $file->storeAs('public/gambar_artikel', $uniqueName);


        $simpan = User::create([
            'jabatan_id'        =>  $request->jabatan_id,
            'nama_lengkap'      =>  $request->nama_lengkap,
            'nik'               =>  $request->nik,
            'tahun_keanggotaan' =>  $request->tahun_keanggotaan,
            'alamat'            =>  $request->alamat,
            'email'             =>  $request->email,
            'image_path'        =>  $request->image_path,
            'passowrd'          =>  $request->passowrd,
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
