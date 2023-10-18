<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SimpananWajib;
use App\Models\JenisTransaksi;
use App\Models\TransaksiKoperasi;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SimpananWajibController extends Controller
{
    public function index(Request $request)
    {
        $nama = $request->query('nama');
        if (!empty($nama)) {
            $anggotas = User::where('nama_lengkap','LIKE','%'.$nama.'%')
                            ->where('nama_lengkap','!=','Operator')
                            ->where('nama_lengkap','!=','Koperasi')
                            ->orWhere('email','LIKE','%'.$nama.'%')
                            ->orderBy('created_at','asc')->paginate(10);
        }else {
            $anggotas = User::where('nama_lengkap','!=','Operator')
                            ->where('nama_lengkap','!=','Koperasi')
                            ->orderBy('created_at','asc')->paginate(10);
        }
        
        return view('backend/simpananWajib.index', [
            'anggotas'  =>  $anggotas,
            'nama'  =>  $nama,
        ]);
    }

    public function simpananWajibAnggota(){
        $anggota = User::where('id',auth()->user()->id)
                        ->with(['jabatan','simpananWajibs' => function ($query) {
                            $query->orderBy('created_at', 'desc');
                        }])                
                        ->first();
        return view('backend/simpananWajib.anggota',[
            'anggota' =>  $anggota,
        ]);
    }

    public function detail(User $anggota){
        $anggota = User::where('id',$anggota->id)
                        ->with(['jabatan','simpananWajibs' => function ($query) {
                            $query->orderBy('created_at', 'desc');
                        }])                
                        ->first();
        return view('backend/simpananWajib.detail',[
            'anggota' =>  $anggota,
        ]);
    }

    public function create()
    {
        $anggotas = User::all();
        return view('backend/simpananWajib.create', [
            'anggotas'   =>  $anggotas,
        ]);
    }

    public function store(Request $request, User $anggota)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_transaksi'     => 'required|numeric',
            'tanggal_transaksi'     => 'required',
            'bulan_transaksi'       => 'required',
            'tahun_transaksi'       => 'required|numeric|digits:4|min:1000|max:9999',
        ], [
            'tanggal_transaksi.required' => 'Kolom Tanggal Transaksi harus diisi.',
            'bulan_transaksi.required' => 'Kolom Bulan Transaksi harus diisi.',
            'tahun_transaksi.required' => 'Kolom Tahun Transaksi harus diisi.',
            'tahun_transaksi.numeric' => 'Kolom Tahun Transaksi harus berupa angka.',
            'tahun_transaksi.digits' => 'Kolom Tahun Transaksi harus terdiri dari 4 digit angka.',
            'tahun_transaksi.min' => 'Kolom Tahun Transaksi harus memiliki nilai minimal 1000.',
            'tahun_transaksi.max' => 'Kolom Tahun Transaksi harus memiliki nilai maksimal 9999.',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $jenisTransaksi = JenisTransaksi::where('id',1)->first();
        DB::beginTransaction();
        try {

            $transaksi = TransaksiKoperasi::create([
                'jenis_transaksi_id'    =>  1,
                'anggota_id'            =>  $anggota->id,
                'operator_id'           =>  Auth::user()->id,
                'kategori_transaksi'       =>  $jenisTransaksi->kategori_transaksi,
                'jumlah_transaksi' =>  $request->jumlah_transaksi,
                'tanggal_transaksi' =>  $request->tanggal_transaksi,
                'bulan_transaksi'   =>  $request->bulan_transaksi,
                'tahun_transaksi'   =>  $request->tahun_transaksi,
            ]);

            $simpan = SimpananWajib::create([
                'transaksi_id'    =>    $transaksi->id,
                'jenis_transaksi_id'    =>  1,
                'anggota_id'            =>  $anggota->id,
                'operator_id'           =>  Auth::user()->id,
                'jumlah_transaksi' =>  $request->jumlah_transaksi,
                'tanggal_transaksi' =>  $request->tanggal_transaksi,
                'bulan_transaksi'   =>  $request->bulan_transaksi,
                'tahun_transaksi'   =>  $request->tahun_transaksi,
            ]);

            
            DB::commit();
            return response()->json([
                'text'  =>  'Yeay, simpanan wajib baru berhasil disimpan',
                'url'   =>  route('simpananWajib.detail',[$anggota->id]),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['text' =>  'Oopps, simpanan wajib gagal disimpan']);
        }
    }

    public function edit(SimpananWajib $simpananWajib)
    {
        return $simpananWajib;
    }

    public function update(Request $request, User $anggota)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_transaksi'     => 'required|numeric',
            'tanggal_transaksi'     => 'required',
            'bulan_transaksi'       => 'required',
            'tahun_transaksi'       => 'required|numeric|digits:4|min:1000|max:9999',
        ], [
            'tanggal_transaksi.required' => 'Kolom Tanggal Transaksi harus diisi.',
            'bulan_transaksi.required' => 'Kolom Bulan Transaksi harus diisi.',
            'tahun_transaksi.required' => 'Kolom Tahun Transaksi harus diisi.',
            'tahun_transaksi.numeric' => 'Kolom Tahun Transaksi harus berupa angka.',
            'tahun_transaksi.digits' => 'Kolom Tahun Transaksi harus terdiri dari 4 digit angka.',
            'tahun_transaksi.min' => 'Kolom Tahun Transaksi harus memiliki nilai minimal 1000.',
            'tahun_transaksi.max' => 'Kolom Tahun Transaksi harus memiliki nilai maksimal 9999.',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $simpananWajib = SimpananWajib::findOrFail($request->simpanan_wajib_id);
        TransaksiKoperasi::where('id',$simpananWajib->transaksi_id)->update([
            'jumlah_transaksi'  =>  $request->jumlah_transaksi,
        ]);
        $update = $simpananWajib->update([
            'jumlah_transaksi' =>  $request->jumlah_transaksi,
            'tanggal_transaksi' =>  $request->tanggal_transaksi,
            'bulan_transaksi'   =>  $request->bulan_transaksi,
            'tahun_transaksi'   =>  $request->tahun_transaksi,
        ]);

        if ($update) {
            return response()->json([
                'text'  =>  'Yeay, simpanan wajib berhasil diubah',
                'url'   =>  route('simpananWajib.detail',[$anggota->id]),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, simpanan wajib gagal diubah']);
        }
    }

    public function delete(Request $request, SimpananWajib $simpananWajib){
        $delete =  $simpananWajib->delete();

        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, simpanan wajib berhasil dihapus',
                'url'   =>  route('simpananWajib.detail',[$request->anggota_id]),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, simpanan wajib gagal dihapus']);
        }
    }
}
