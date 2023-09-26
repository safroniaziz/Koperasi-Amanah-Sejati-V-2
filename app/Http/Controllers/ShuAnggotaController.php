<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ShuAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShuAnggotaController extends Controller
{
    public function index(){
        $shus = ShuAnggota::with('anggota.jabatan')
                            ->groupBy('anggota_id')
                            ->get();
        return view('backend.shu.index',[
            'shus'  =>  $shus,
        ]);
    }

    public function detail(User $anggota){
        $shus = ShuAnggota::select(
            'id',
            'anggota_id',
            'tahun',
            DB::raw('SUM(shu_simpanan) as total_shu_simpanan'),
            DB::raw('SUM(shu_jasa) as total_shu_jasa')
        )
        ->where('anggota_id',$anggota->id)
        ->groupBy('tahun')
        ->orderBy('tahun','desc')
        ->get();
        return view('backend.shu.detail',[
            'anggota'  =>  $anggota,
            'shus'  =>  $shus,
        ]); 
    }

    public function shuAnggota(){
        $shus = ShuAnggota::select(
            'anggota_id',
            'tahun',
            DB::raw('SUM(shu_simpanan) as total_shu_simpanan'),
            DB::raw('SUM(shu_jasa) as total_shu_jasa')
        )
        ->where('anggota_id',auth()->user()->id)
        ->groupBy('tahun')
        ->orderBy('tahun','desc')
        ->get();
        return view('backend.shu.anggota',[
            'shus'  =>  $shus,
        ]); 
    }

    public function edit(ShuAnggota $shu){
        return $shu;
    }

    public function store(User $anggota, Request $request){
        $validator = Validator::make($request->all(), [
            'shu_simpanan' => 'required',
            'shu_jasa' => 'required',
            'jumlah' => 'required',
        ], [
            'shu_simpanan.required' => 'Kolom SHU Simpanan harus diisi.',
            'shu_jasa.required' => 'Kolom SHU Jasa harus diisi.',
            'jumlah.required' => 'Kolom Jumlah harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $simpan = ShuAnggota::create([
            'anggota_id'    =>  $anggota->id,
            'shu_simpanan'  =>  $request->shu_simpanan,
            'shu_jasa'  =>  $request->shu_jasa,
            'tahun'     =>  $request->tahun,
            'jumlah'  =>  $request->jumlah,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, shu anggota berhasil disimpan',
                'url'   =>  route('shu.detail',[$anggota->id]),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, shu anggota gagal disimpan']);
        }
    }

    public function update(User $anggota, Request $request){
        $validator = Validator::make($request->all(), [
            'shu_simpanan' => 'required',
            'shu_jasa' => 'required',
            'jumlah' => 'required',
        ], [
            'shu_simpanan.required' => 'Kolom SHU Simpanan harus diisi.',
            'shu_jasa.required' => 'Kolom SHU Jasa harus diisi.',
            'jumlah.required' => 'Kolom Jumlah harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        $simpan = ShuAnggota::where('id',$request->shu_id)->update([
            'anggota_id'    =>  $anggota->id,
            'shu_simpanan'  =>  $request->shu_simpanan,
            'shu_jasa'  =>  $request->shu_jasa,
            'tahun'     =>  $request->tahun,
            'jumlah'  =>  $request->jumlah,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, shu anggota berhasil diupdate',
                'url'   =>  route('shu.detail',[$anggota->id]),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, shu anggota gagal diupdate']);
        }
    }

    public function delete(User $anggota, ShuAnggota $shu){
        $delete = $shu->delete();
        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, shu anggota berhasil dihapus',
                'url'   =>  route('shu.detail',[$anggota->id]),
            ]);
        }else {
            return response()->json(['text' =>  'Oopps, shu anggota gagal dihapus']);
        }
    }
}
