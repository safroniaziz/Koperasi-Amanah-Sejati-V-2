<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\ModalAwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TabelarisKeluarController extends Controller
{
    public function index(){
        return view('backend/tabelarisKeluar.index');
    }

    public function cari(Request $request){
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

            $kasKeluars = User::active()
                            ->with(['simpananWajibs' => function($query) use ($request) {
                                $query->whereYear('tanggal_transaksi', $request->tahun)
                                    ->whereMonth('tanggal_transaksi', $request->bulan);
                            }])
                            ->withSum(['simpananWajibs' => function($query) use ($request) {
                                $query->whereYear('tanggal_transaksi', $request->tahun)
                                    ->whereMonth('tanggal_transaksi', $request->bulan);
                            }], 'jumlah_transaksi')
                            ->where('nama_lengkap', '!=', 'Operator')
                            ->orderBy('id', 'asc')
                            ->get();

            $modalAwal = ModalAwal::where('tahun',$request->tahun)->where('bulan',$request->bulan)->first();
            $namaBulan = date('F', mktime(0, 0, 0, $request->bulan, 1));
            $tanggal = $namaBulan . ' ' . $request->tahun;
            request()->session()->put('tahun_tabelaris_keluar', $request->tahun);
            request()->session()->put('bulan_tabelaris_keluar', $request->bulan);
            return view('backend.tabelarisKeluar.index',[
                'bulan' =>  $request->bulan,
                'tahun' =>  $request->tahun,
                'tanggal' =>  $tanggal,
                'kasKeluars' =>  $kasKeluars,
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

    public function pdf(Request $request){
        $kasKeluars = User::active()
                            ->with(['simpananWajibs' => function($query) use ($request) {
                                $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_keluar'))
                                    ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_keluar'));
                            }])
                            ->withSum(['simpananWajibs' => function($query) use ($request) {
                                $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_keluar'))
                                    ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_keluar'));
                            }], 'jumlah_transaksi')
                            ->with(['simpananPokok' => function($query) use ($request) {
                                $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_keluar'))
                                    ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_keluar'));
                            }])
                            ->withSum(['simpananPokok' => function($query) use ($request) {
                                $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_keluar'))
                                    ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_keluar'));
                            }], 'jumlah_transaksi')
                            ->withSum(['angsurans' => function($query) use ($request) {
                                $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_keluar'))
                                    ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_keluar'));
                            }], 'angsuran_pokok')
                            ->withSum(['angsurans' => function($query) use ($request) {
                                $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_keluar'))
                                    ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_keluar'));
                            }], 'angsuran_jasa')
                            ->where('nama_lengkap', '!=', 'Operator')
                            ->orderBy('id', 'asc')
                            ->get();

        $modalAwal = ModalAwal::where('tahun', request()->session()->get('tahun_tabelaris_keluar'))->where('bulan',request()->session()->get('bulan_tabelaris_keluar'))->first();

        $namaBulan = date('F', mktime(0, 0, 0, $request->bulan, 1));
        $tanggal = $namaBulan . ' ' .  request()->session()->get('tahun_tabelaris_keluar');

        $pdf = PDF::loadView('backend.tabelarisKeluar.cetak',[
            'kasKeluars'    =>  $kasKeluars,
            'modalAwal'    =>  $modalAwal,
            'tanggal'    =>  $tanggal,
        ]);
        $margin = [
            'top' => 2,    // Margin atas
            'right' => 2,  // Margin kanan
            'bottom' => 2, // Margin bawah
            'left' => 2    // Margin kiri
        ];
        $pdf->setPaper('a4','landscape');
        $pdf->setOptions(['margin' => $margin]);
        return $pdf->stream('tabelaris_kas_keluar-'.$tanggal.'.pdf');
    }
}