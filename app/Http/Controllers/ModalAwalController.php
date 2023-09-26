<?php

namespace App\Http\Controllers;

use App\Models\ModalAwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModalAwalController extends Controller
{
    public function index()
    {
        $modalAwals = ModalAwal::orderBy('created_at','desc')->get();
        return view('backend/modalAwal.index', [
            'modalAwals'  =>  $modalAwals,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'tahun'       => 'required|numeric|digits:4|min:1000|max:9999',
            'bulan'       => 'required',
            'modal_awal'           => 'required|numeric',
        ];
        $text = [
            'tahun.required'      => 'Kolom Tahun harus diisi.',
            'tahun.numeric'       => 'Kolom Tahun harus berupa angka.',
            'tahun.digits'        => 'Kolom Tahun harus terdiri dari 4 digit.',
            'tahun.min'           => 'Kolom Tahun harus memiliki nilai minimal 1000.',
            'tahun.max'           => 'Kolom Tahun harus memiliki nilai maksimal 9999.',
            'bulan.required'      => 'Kolom Bulan harus diisi.',
            'modal_awal.required'          => 'Kolom Modal Awal harus diisi.',
            'modal_awal.numeric'            => 'Kolom Modal Awal harus berupa numeric.',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $simpan = ModalAwal::create([
            'tahun'            =>  $request->tahun,
            'bulan'      =>  $request->bulan,
            'modal_awal'     =>  $request->modal_awal,
        ]);

        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, modal awal berhasil disimpan',
                'url'   =>  url('/modal_awal/'),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, modal awal gagal disimpan']);
        }
    }

    public function edit(ModalAwal $modalAwal)
    {
        return $modalAwal;
    }

    public function update(Request $request)
    {
        $rules = [
            'tahun'       => 'required|numeric|digits:4|min:1000|max:9999',
            'bulan'       => 'required',
            'modal_awal'           => 'required|numeric',
        ];
        $text = [
            'tahun.required'      => 'Kolom Tahun harus diisi.',
            'tahun.numeric'       => 'Kolom Tahun harus berupa angka.',
            'tahun.digits'        => 'Kolom Tahun harus terdiri dari 4 digit.',
            'tahun.min'           => 'Kolom Tahun harus memiliki nilai minimal 1000.',
            'tahun.max'           => 'Kolom Tahun harus memiliki nilai maksimal 9999.',
            'bulan.required'      => 'Kolom Bulan harus diisi.',
            'modal_awal.required'          => 'Kolom Modal Awal harus diisi.',
            'modal_awal.numeric'            => 'Kolom Modal Awal harus berupa numeric.',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        $modalAwal = ModalAwal::where('id',$request->modal_awal_id)->first();
        $simpan = $modalAwal->update([
            'tahun'            =>  $request->tahun,
            'bulan'      =>  $request->bulan,
            'modal_awal'     =>  $request->modal_awal,
        ]);
        if ($simpan) {
            return response()->json([
                'text'  =>  'Yeay, modal awal berhasil diubah',
                'url'   =>  url('/modal_awal/'),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, modal awal gagal diubah']);
        }
    }

    public function delete(ModalAwal $modalAwal){
        $delete = $modalAwal->delete();

        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, modal awal berhasil dihapus',
                'url'   =>  url('/modal_awal/'),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, modal awal gagal dihapus']);
        }
    }
}
