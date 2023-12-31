<?php

namespace App\Http\Controllers;

use App\Exports\BukuKasPembantuExport;
use DateTime;
use Carbon\Carbon;
use App\Models\ModalAwal;
use Illuminate\Http\Request;
use App\Models\TransaksiKoperasi;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PDF;

class BukuKasPembantuController extends Controller
{
    public function index(){
        return view('backend.bukuKasPembantu.index');
    }

    public function exportDataPdf(Request $request){
        $tahunBukuKas = $request->session()->get('tahunBukuKas');
        $bulanBukuKas = $request->session()->get('bulanBukuKas');

        $modalAwal = ModalAwal::where('tahun',$tahunBukuKas)->where('bulan',$bulanBukuKas)->first();
        if (!$modalAwal) {
            $notification = array(
                'message' => 'Oooopps, modal awal '.$bulanBukuKas.' tahun '.$tahunBukuKas.' belum ditambahkan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $transaksis = TransaksiKoperasi::with(['jenisTransaksi','anggota'])->whereYear('tanggal_transaksi',$tahunBukuKas)
                                        ->whereMonth('tanggal_transaksi',$bulanBukuKas)
                                        ->where('jenis_transaksi_id','!=',24)
                                        ->where('jenis_transaksi_id','!=',25)
                                        ->orderBy('tanggal_transaksi','asc')
                                        ->get();
        $pdf = PDF::loadView('backend.bukuKasPembantu.cetak',[
            'bulan' =>  $bulanBukuKas,
            'tahun' =>  $tahunBukuKas,
            'transaksis' =>  $transaksis,
            'modalAwal' =>  $modalAwal,
        ]);
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('buku-kas-pembantu-'.$tahunBukuKas.'-'.$bulanBukuKas.'.pdf');
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
            $namaBulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];

            $modalAwal = ModalAwal::where('tahun',$request->tahun)->where('bulan',$request->bulan)->first();
            if (!$modalAwal) {
                $notification = array(
                    'message' => 'Oooopps, modal awal '.$namaBulan[$request->bulan_transaksi].' tahun '.$request->tahun.' belum ditambahkan',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
            $request->session()->put('tahunBukuKas', $request->input('tahun'));
            $request->session()->put('bulanBukuKas', $request->input('bulan'));
            $transaksis = TransaksiKoperasi::with(['jenisTransaksi','anggota'])->whereYear('tanggal_transaksi',$request->tahun)
                                            ->whereMonth('tanggal_transaksi',$request->bulan)
                                            ->where('jenis_transaksi_id','!=',24)
                                            ->where('jenis_transaksi_id','!=',25)
                                            ->orderBy('tanggal_transaksi','asc')
                                            ->get();
            return view('backend.bukuKasPembantu.index',[
                'bulan' =>  $request->bulan,
                'tahun' =>  $request->tahun,
                'transaksis' =>  $transaksis,
                'modalAwal' =>  $modalAwal,
            ]);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Oooopps, mohon maaf ada kesalahan, mungkin anda belum menginputkan modal awal pada bulan dan tahun yang dipilih',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function exportData(Request $request)
    {
        // Ambil inputan dari variabel sementara (session)
        $tahunBukuKas = $request->session()->get('tahunBukuKas');
        $bulanBukuKas = $request->session()->get('bulanBukuKas');
        
        // Buat query berdasarkan inputan
        $query = TransaksiKoperasi::query();
        $modalAwal = ModalAwal::where('tahun',$tahunBukuKas)->where('bulan',$bulanBukuKas)->first();
        if ($tahunBukuKas && $bulanBukuKas) {
            $query->with(['jenisTransaksi','anggota'])->whereYear('tanggal_transaksi', $tahunBukuKas)
                ->whereMonth('tanggal_transaksi', $bulanBukuKas)
                ->where('jenis_transaksi_id','!=',24)
                ->where('jenis_transaksi_id','!=',25)
                ->orderBy('tanggal_transaksi', 'asc');
        }

        $data = $query->get();
        $bulan = $bulanBukuKas;
        $tahun = $tahunBukuKas;
        
        return Excel::download(new BukuKasPembantuExport($data,$modalAwal, $bulan, $tahun), 'buku-kas-pembantu-'.$bulan.'-'.$tahun.'.xlsx');
    }

}
