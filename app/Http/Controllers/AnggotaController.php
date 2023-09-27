<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    public function index(Request $request){
        $nama = $request->query('nama');
        if (!empty($nama)) {
            $anggotas = User::anggota()->where(function ($query) use ($nama) {
                                $query->where('nama_lengkap', 'LIKE', '%' . $nama . '%')
                                    ->orWhere('email', 'LIKE', '%' . $nama . '%');
                            })
                            ->orderBy('created_at', 'asc')
                            ->paginate(10);
        }else {
            $anggotas = User::anggota()
                            ->orderBy('created_at','asc')->paginate(10);
        }

        return view('backend/anggota.index',[
            'anggotas'  =>  $anggotas,
            'nama'  =>  $nama,
        ]);
    }

    public function create(){
        $jabatans = Jabatan::where('nama_jabatan','!=','Operator')->get();
        return view('backend/anggota.create',[
            'jabatans'   =>  $jabatans,
        ]);
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'jabatan_id'            => 'required',
            'nama_lengkap'          => 'required',
            'nik'                   => 'required|numeric',
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
        $jabatans = Jabatan::all();
        return view('backend.anggota.edit',[
            'anggota'   =>  $anggota,
            'jabatans'  =>  $jabatans,
        ]);
    }

    public function update(Request $request){
        $anggota = User::findOrFail($request->anggota_id_edit);
        $validator = Validator::make($request->all(), [
            'jabatan_id' => 'required',
            'nama_lengkap' => 'required',
            'nik' => [
                'required',
                'numeric',
            ],
            'tahun_keanggotaan' => 'required|digits:4|numeric|min:1000|max:9999',
            'alamat' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($anggota->id),
            ],
            'image_path' => 'image|mimes:png,jpg,jpeg|max:1000',
        ], [
            'jabatan_id.required'           => 'Kolom Jabatan harus diisi.',
            'nama_lengkap.required'         => 'Kolom Nama Lengkap harus diisi.',
            'nik.required'                  => 'Kolom NIK harus diisi.',
            'nik.numeric'                   => 'Kolom NIK harus berupa angka.',
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
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $uniqueName = null;
        $file = $request->file('image_path');
        if ($file) {
            // Menghapus file gambar lama jika ada
            if ($oldFilePath = $anggota->image_path) {
                Storage::delete('public/foto_anggota/' . $oldFilePath);
            }

            $uniqueName = $request->nik . '-' . Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_anggota/', $uniqueName);
        }

        $update = $anggota->update([
            'jabatan_id'            =>  $request->jabatan_id,
            'nama_lengkap'          =>  $request->nama_lengkap,
            'nik'                   =>  $request->nik,
            'alamat'                =>  $request->alamat,
            'tahun_keanggotaan'     =>  $request->tahun_keanggotaan,
            'simpanan_pokok'        =>  500000,
            'email'                 =>  $request->email,
            'image_path'            =>  $uniqueName,
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

    public function delete(User $anggota){
        $file = $anggota->image_path;
        if ($file) {
            // Menghapus file gambar lama jika ada
            if ($oldFilePath = $anggota->image_path) {
                Storage::delete('public/foto_anggota/' . $oldFilePath);
            }
        }

        $delete = $anggota->delete();

        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, data anggota berhasil dihapus',
                'url'   =>  url('/anggota/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, data anggota gagal dihapus']);
        }
    }

    public function updatePassword (Request $request){
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'min:8',            // Panjang minimal 8 karakter
                'max:20',           // Panjang maksimal 20 karakter
                'confirmed',        // Password harus dikonfirmasi
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                // Aturan untuk kombinasi karakter (minimal 1 huruf besar, 1 huruf kecil, 1 angka, 1 karakter khusus)
            ],
        ], [
            'password.required' => 'Kolom password harus diisi.',
            'password.min' => 'Password harus memiliki panjang minimal :min karakter.',
            'password.max' => 'Password tidak boleh melebihi :max karakter.',
            'password.confirmed' => 'Password dan konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung setidaknya 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter khusus.',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $updatePassword = User::where('id',$request->id)->update([
            'password'  =>  Hash::make($request->password),
        ]);

        if ($updatePassword) {
            return response()->json([
                'text'  =>  'Yeay, password anggota berhasil diubah',
                'url'   =>  url('/anggota/'),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, password anggota gagal diubah']);
        }
    }
}
