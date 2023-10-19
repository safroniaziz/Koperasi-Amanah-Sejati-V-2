<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\ModalAwal;
use App\Models\SaldoKasAwal;
use Illuminate\Http\Request;
use App\Models\TransaksiKoperasi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TabelarisMasukExport;
use Illuminate\Support\Facades\Validator;

class TabelarisMasukController extends Controller
{
    public function index(){
        return view('backend/tabelarisMasuk.index2');
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
            $request->session()->put('tahunKasMasuk', $request->input('tahun'));
            $request->session()->put('bulanKasMasuk', $request->input('bulan'));
            $transaksis = TransaksiKoperasi::with(['jenisTransaksi' => function ($query) {
                                                $query->where('kategori_transaksi', 'masuk');
                                            }, 'anggota'])
                                            ->whereYear('tanggal_transaksi', $request->tahun)
                                            ->whereMonth('tanggal_transaksi', $request->bulan)
                                            ->whereHas('jenisTransaksi', function ($query) {
                                                $query->where('kategori_transaksi', 'masuk');
                                            })
                                            ->orderBy('tanggal_transaksi', 'asc')
                                            ->get();
        
            return view('backend.tabelarisMasuk.index2',[
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
        $tahunKasMasuk = $request->session()->get('tahunKasMasuk');
        $bulanKasMasuk = $request->session()->get('bulanKasMasuk');
        
        // Buat query berdasarkan inputan
        $query = TransaksiKoperasi::query();
        $modalAwal = ModalAwal::where('tahun',$tahunKasMasuk)->where('bulan',$bulanKasMasuk)->first();
        if ($tahunKasMasuk && $bulanKasMasuk) {
            $query->with(['jenisTransaksi' => function ($query) {
                        $query->where('kategori_transaksi', 'masuk');
                    }, 'anggota'])
                    ->whereYear('tanggal_transaksi', $tahunKasMasuk)
                    ->whereMonth('tanggal_transaksi', $bulanKasMasuk)
                    ->whereHas('jenisTransaksi', function ($query) {
                        $query->where('kategori_transaksi', 'masuk');
                    })
                    ->orderBy('tanggal_transaksi', 'asc')
                    ->get();
        }

        $data = $query->get();
        $bulan = $bulanKasMasuk;
        $tahun = $tahunKasMasuk;
        return [
            'bulan' =>  $bulan,
            'tahun' =>  $tahun,
        ];
        
        return Excel::download(new TabelarisMasukExport($data,$modalAwal, $bulan, $tahun), 'data.xlsx');
    }

    // public function cari(Request $request){
    //     $rules = [
    //         'bulan'       => 'required',
    //         'tahun'       => 'required|numeric|digits:4|min:1000|max:9999',
    //     ];
    //     $text = [
    //         'bulan.required'      => 'Kolom Bulan harus diisi.',
    //         'tahun.required'      => 'Kolom Tahun harus diisi.',
    //         'tahun.numeric'       => 'Kolom Tahun harus berupa angka.',
    //         'tahun.digits'        => 'Kolom Tahun harus terdiri dari 4 digit.',
    //         'tahun.min'           => 'Kolom Tahun harus memiliki nilai minimal 1000.',
    //         'tahun.max'           => 'Kolom Tahun harus memiliki nilai maksimal 9999.',
    //     ];

    //     $validasi = Validator::make($request->all(), $rules, $text);
    //     if ($validasi->fails()) {
    //         return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
    //     }
        
    //     $bulans = [
    //         '01' => 'Januari',
    //         '02' => 'Februari',
    //         '03' => 'Maret',
    //         '04' => 'April',
    //         '05' => 'Mei',
    //         '06' => 'Juni',
    //         '07' => 'Juli',
    //         '08' => 'Agustus',
    //         '09' => 'September',
    //         '10' => 'Oktober',
    //         '11' => 'November',
    //         '12' => 'Desember'
    //     ];

    //     if ($request->bulan == "01") {
    //         $tahun = $request->tahun-1;
    //         $angkaBulanSebelumnya = 12;
    //         $namaBulanSebelumnya = "Desember";
    //     }else{
    //         $tahun = $request->tahun;
    //         $namaBulan = $bulans[$request->bulan];
    //         $angkaBulanSebelumnya = $request->bulan - 1;
    //         if ($angkaBulanSebelumnya < '01') {
    //             $angkaBulanSebelumnya = '12'; // Bulan sebelumnya dari '01' adalah '12'
    //         }
    //         $angkaBulanSebelumnya = str_pad($angkaBulanSebelumnya, 2, '0', STR_PAD_LEFT);
    //         $namaBulanSebelumnya = $bulans[$angkaBulanSebelumnya];
    //     }
        
    //     $saldoKasAwal = ModalAwal::where('tahun', $request->tahun)->where('bulan',$request->bulan)->first();
    //     if ($saldoKasAwal != null) {
    //         try {
    //             $kasMasuks = User::active()
    //                             ->with(['simpananWajibs' => function($query) use ($request) {
    //                                 $query->whereYear('tanggal_transaksi', $request->tahun)
    //                                     ->whereMonth('tanggal_transaksi', $request->bulan);
    //                             }])
    //                             ->withSum(['simpananWajibs' => function($query) use ($request) {
    //                                 $query->whereYear('tanggal_transaksi', $request->tahun)
    //                                     ->whereMonth('tanggal_transaksi', $request->bulan);
    //                             }], 'jumlah_transaksi')
    //                             ->with(['simpananPokok' => function($query) use ($request) {
    //                                 $query->whereYear('tanggal_transaksi', $request->tahun)
    //                                     ->whereMonth('tanggal_transaksi', $request->bulan);
    //                             }])
    //                             ->withSum(['simpananPokok' => function($query) use ($request) {
    //                                 $query->whereYear('tanggal_transaksi', $request->tahun)
    //                                     ->whereMonth('tanggal_transaksi', $request->bulan);
    //                             }], 'jumlah_transaksi')
    //                             ->withSum(['angsurans' => function($query) use ($request) {
    //                                 $query->whereYear('tanggal_transaksi', $request->tahun)
    //                                     ->whereMonth('tanggal_transaksi', $request->bulan);
    //                             }], 'angsuran_pokok')
    //                             ->withSum(['angsurans' => function($query) use ($request) {
    //                                 $query->whereYear('tanggal_transaksi', $request->tahun)
    //                                     ->whereMonth('tanggal_transaksi', $request->bulan);
    //                             }], 'angsuran_jasa')
    //                             ->where('nama_lengkap', '!=', 'Operator')
    //                             ->orderBy('id', 'asc')
    //                             ->get();
    
    //             $namaBulan = date('F', mktime(0, 0, 0, $request->bulan, 1));
    //             $tanggal = $namaBulan . ' ' . $tahun;
    //             request()->session()->put('tahun_tabelaris_masuk', $tahun);
    //             request()->session()->put('bulan_tabelaris_masuk', $angkaBulanSebelumnya);
    //             return view('backend.tabelarisMasuk.index',[
    //                 'bulan' =>  $angkaBulanSebelumnya,
    //                 'bulanSekarang' =>  $request->bulan,
    //                 'tahun' =>  $tahun,
    //                 'tanggal' =>  $tanggal,
    //                 'kasMasuks' =>  $kasMasuks,
    //                 'saldoKasAwal' =>  $saldoKasAwal,
    //                 'namaBulanSebelumnya' =>  $namaBulanSebelumnya,
    //             ]);
    //         } catch (\Exception $e) {
    //             $notification = array(
    //                 'message' => 'Oooopps, Harap untuk memilih bulan dan tahun dari form',
    //                 'alert-type' => 'error'
    //             );
    //             return redirect()->back()->with($notification);
    //         }
    //     }else {
    //         $notification = array(
    //             'message' => 'Oooopps, Harap simpan saldo kas pada bulan '.$namaBulanSebelumnya.' Tahun '.$tahun. ' terlebih dahulu',
    //             'alert-type' => 'error'
    //         );
    //         return redirect()->route('tabelarisMasuk')->with($notification);
    //     }
    // }

    // public function pdf(Request $request){
    //     $kasMasuks = User::active()
    //                         ->with(['simpananWajibs' => function($query) use ($request) {
    //                             $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_masuk'))
    //                                 ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_masuk'));
    //                         }])
    //                         ->withSum(['simpananWajibs' => function($query) use ($request) {
    //                             $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_masuk'))
    //                                 ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_masuk'));
    //                         }], 'jumlah_transaksi')
    //                         ->with(['simpananPokok' => function($query) use ($request) {
    //                             $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_masuk'))
    //                                 ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_masuk'));
    //                         }])
    //                         ->withSum(['simpananPokok' => function($query) use ($request) {
    //                             $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_masuk'))
    //                                 ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_masuk'));
    //                         }], 'jumlah_transaksi')
    //                         ->withSum(['angsurans' => function($query) use ($request) {
    //                             $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_masuk'))
    //                                 ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_masuk'));
    //                         }], 'angsuran_pokok')
    //                         ->withSum(['angsurans' => function($query) use ($request) {
    //                             $query->whereYear('tanggal_transaksi',  request()->session()->get('tahun_tabelaris_masuk'))
    //                                 ->whereMonth('tanggal_transaksi', request()->session()->get('bulan_tabelaris_masuk'));
    //                         }], 'angsuran_jasa')
    //                         ->where('nama_lengkap', '!=', 'Operator')
    //                         ->orderBy('id', 'asc')
    //                         ->get();
    //     $modalAwal = ModalAwal::where('tahun', request()->session()->get('tahun_tabelaris_masuk'))->where('bulan',request()->session()->get('bulan_tabelaris_masuk'))->first();

    //     $namaBulan = date('F', mktime(0, 0, 0, $request->bulan, 1));
    //     $tanggal = $namaBulan . ' ' .  request()->session()->get('tahun_tabelaris_masuk');

    //     $pdf = PDF::loadView('backend.tabelarisMasuk.cetak',[
    //         'kasMasuks'    =>  $kasMasuks,
    //         'modalAwal'    =>  $modalAwal,
    //         'tanggal'    =>  $tanggal,
    //     ]);
    //     $margin = [
    //         'top' => 2,    // Margin atas
    //         'right' => 2,  // Margin kanan
    //         'bottom' => 2, // Margin bawah
    //         'left' => 2    // Margin kiri
    //     ];
    //     $pdf->setPaper('a4','landscape');
    //     $pdf->setOptions(['margin' => $margin]);
    //     return $pdf->stream('tabelaris_kas_masuk-'.$tanggal.'.pdf');
    // }

    // public function modalAwalPost(Request $request) {
    //     $saldo = SaldoKasAwal::firstOrCreate([
    //         'tahun' => $request->tahun,
    //         'bulan' => $request->bulan,
    //     ], [
    //         'jumlah' => $request->saldo_kas,
    //     ]);
    
    //     if ($saldo->wasRecentlyCreated) {
    //         $notification = array(
    //             'message' => 'Yeayy, Saldo Kas Awal Bulan ' . $request->bulan . ' Tahun ' . $request->tahun . ' Berhasil Disimpan',
    //             'alert-type' => 'success'
    //         );
    //     } else {
    //         $notification = array(
    //             'message' => 'Ooopps, Saldo Kas Awal Bulan ' . $request->bulan . ' Tahun ' . $request->tahun . ' Sudah Ada',
    //             'alert-type' => 'error'
    //         );
    //     }
    //     return redirect()->back()->with($notification);
    // }
}
