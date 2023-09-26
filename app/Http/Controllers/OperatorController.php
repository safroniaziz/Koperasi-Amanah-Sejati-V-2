<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OperatorController extends Controller
{
    public function index(Request $request){
        $nama = $request->query('nama');
        if (!empty($nama)) {
            $operators = User::operator()
                            ->where('nama_lengkap','LIKE','%'.$nama.'%')
                            ->orWhere('email','LIKE','%'.$nama.'%')
                            ->orderBy('created_at','asc')->paginate(10);
        }else {
            $operators = User::operator()
                            ->orderBy('created_at','asc')->paginate(10);
        }

        return view('backend/operator.index',[
            'operators'  =>  $operators,
            'nama'  =>  $nama,
        ]);
    }

    public function create(){
        $jabatans = Jabatan::where('nama_jabatan','!=','Operator')->get();
        return view('backend/operator.create',[
            'jabatans'   =>  $jabatans,
        ]);
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'jabatan_id'            => 'required',
            'nama_lengkap'          => 'required',
            'nik'                   => 'required|numeric',
            'tahun_keoperatoran'     => 'required|digits:4|numeric|min:1000|max:9999',
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
            'tahun_keoperatoran.required'    => 'Kolom Tahun Keoperatoran harus diisi.',
            'tahun_keoperatoran.digits'      => 'Kolom Tahun Keoperatoran harus berisi 4 digit.',
            'tahun_keoperatoran.numeric'     => 'Kolom Tahun Keoperatoran harus berupa angka.',
            'tahun_keoperatoran.min'         => 'Kolom Tahun Keoperatoran minimal 4 digit.',
            'tahun_keoperatoran.max'         => 'Kolom Tahun Keoperatoran maksimal 4 digit.',
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
            $file->storeAs('public/foto_operator/', $uniqueName);
        }

        $simpan = User::create([
            'jabatan_id'            =>  $request->jabatan_id,
            'nama_lengkap'          =>  $request->nama_lengkap,
            'nik'                   =>  $request->nik,
            'alamat'                =>  $request->alamat,
            'tahun_keoperatoran'     =>  $request->tahun_keoperatoran,
            'simpanan_pokok'        =>  500000,
            'email'                 =>  $request->email,
            'password'              =>  bcrypt($request->password),
            'image_path'            =>  $uniqueName,
            'is_active'             =>  1,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, data operator berhasil disimpan',
                'url'   =>  url('/operator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, data operator gagal disimpan']);
        }
    }

    public function edit(User $operator){
        $jabatans = Jabatan::all();
        return view('backend.operator.edit',[
            'operator'   =>  $operator,
            'jabatans'  =>  $jabatans,
        ]);
    }

    public function update(Request $request){
        $operator = User::findOrFail($request->operator_id_edit);
        $validator = Validator::make($request->all(), [
            'jabatan_id' => 'required',
            'nama_lengkap' => 'required',
            'nik' => [
                'required',
                'numeric',
            ],
            'tahun_keoperatoran' => 'required|digits:4|numeric|min:1000|max:9999',
            'alamat' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($operator->id),
            ],
            'image_path' => 'image|mimes:png,jpg,jpeg|max:1000',
        ], [
            'jabatan_id.required'           => 'Kolom Jabatan harus diisi.',
            'nama_lengkap.required'         => 'Kolom Nama Lengkap harus diisi.',
            'nik.required'                  => 'Kolom NIK harus diisi.',
            'nik.numeric'                   => 'Kolom NIK harus berupa angka.',
            'tahun_keoperatoran.required'    => 'Kolom Tahun Keoperatoran harus diisi.',
            'tahun_keoperatoran.digits'      => 'Kolom Tahun Keoperatoran harus berisi 4 digit.',
            'tahun_keoperatoran.numeric'     => 'Kolom Tahun Keoperatoran harus berupa angka.',
            'tahun_keoperatoran.min'         => 'Kolom Tahun Keoperatoran minimal 4 digit.',
            'tahun_keoperatoran.max'         => 'Kolom Tahun Keoperatoran maksimal 4 digit.',
            'alamat.required'               => 'Kolom Alamat harus diisi.',
            'email.required'                => 'Kolom Email harus diisi.',
            'email.email'                   => 'Format Email tidak valid.',
            'email.unique'                  => 'Email sudah digunakan.',
            'image_path.image'              => 'File yang diunggah harus berupa gambar.',
            'image_path.mimes'              => 'Format file gambar harus PNG, JPG, atau JPEG.',
            'image_path.max'                => 'Ukuran file gambar maksimal 1000 KB (1 MB).',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $uniqueName = null;
        $file = $request->file('image_path');
        if ($file) {
            // Menghapus file gambar lama jika ada
            if ($oldFilePath = $operator->image_path) {
                Storage::delete('public/foto_operator/' . $oldFilePath);
            }

            $uniqueName = $request->nik . '-' . Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_operator/', $uniqueName);
        }

        $update = $operator->update([
            'jabatan_id'            =>  $request->jabatan_id,
            'nama_lengkap'          =>  $request->nama_lengkap,
            'nik'                   =>  $request->nik,
            'alamat'                =>  $request->alamat,
            'tahun_keoperatoran'     =>  $request->tahun_keoperatoran,
            'simpanan_pokok'        =>  500000,
            'email'                 =>  $request->email,
            'image_path'            =>  $uniqueName,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, data operator berhasil diubah',
                'url'   =>  url('/operator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, data operator gagal diubah']);
        }
    }

    public function delete(User $operator){
        $file = $operator->image_path;
        if ($file) {
            // Menghapus file gambar lama jika ada
            if ($oldFilePath = $operator->image_path) {
                Storage::delete('public/foto_operator/' . $oldFilePath);
            }
        }

        $delete = $operator->delete();

        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, data operator berhasil dihapus',
                'url'   =>  url('/operator/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, data operator gagal dihapus']);
        }
    }
}
