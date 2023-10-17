<?php

namespace App\Http\Controllers;

use App\Models\ModalAwal;
use App\Models\TransaksiKoperasi;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuKasPembantuController extends Controller
{
    public function index(){
        return view('backend.bukuKasPembantu.index');
    }

    public function cariBukuKas(Request $request){
        try {
            $rules = [
                'bulan'       => 'required',
                'tahun'       => 'required|numeric|digits:4|min:1000|max:9999',
            ];
            $text = [
                'bulan.required'      => 'Kolom Bulan harus diisi.',
                'tahun.required'      => 'Kolom Tahun harus diisi.',
                'tahun.numeric'       => 'Kolom Tahun harus berupa angka.',
                'tahun.digits'        => 'Kolom Tahun harus terdiri dari 4 digit.',
                'tahun.min'           => 'Kolom Tahun harus memiliki nilai minimal 1000.',
                'tahun.max'           => 'Kolom Tahun harus memiliki nilai maksimal 9999.',
            ];

            $validasi = Validator::make($request->all(), $rules, $text);
            if ($validasi->fails()) {
                return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
            }

            $modalAwal = ModalAwal::where('tahun',$request->tahun)->where('bulan',$request->bulan)->first();

            $transaksis = TransaksiKoperasi::whereYear('tanggal_transaksi',$request->tahun)
                                            ->whereMonth('tanggal_transaksi',$request->bulan)
                                            ->orderBy('tanggal_transaksi','asc')
                                            ->get();
                                            return $request->all();
            return view('backend.bukuKasPembantu.index',[
                'bulan' =>  $request->bulan,
                'tahun' =>  $request->tahun,
                'transaksis' =>  $transaksis,
                'modalAwal' =>  $modalAwal,
            ]);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Oooopps, Harap untuk memilih bulan dan tahun dari form',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
