<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiTelurExport;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\JenisTransaksi;
use App\Models\TransaksiTelur;
use App\Models\TransaksiKoperasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class TransaksiTelurController extends Controller
{
    private $anggotas;

    public function __construct() {
        $this->anggotas = User::all();
    }
    public function index(Request $request)
    {
        $nama = $request->query('nama');
        if (!empty($nama)) {
            $transaksiTelurs = TransaksiTelur::with(['jenisTransaksi','anggota'])
                                ->where('keterangan', 'like', '%' . $nama . '%')
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        }else{
            $transaksiTelurs = TransaksiTelur::with(['jenisTransaksi','user'])->orderBy('created_at','desc')->paginate(10);
        }   
        return view('backend/transaksiTelur.index', [
            'transaksiTelurs'  =>  $transaksiTelurs,
            'nama'  =>  $nama,
        ]);
    }

    public function create()
    {
        return view('backend/transaksiTelur.create', [
            'anggotas'   =>  $this->anggotas,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'jenis_transaksi'      => 'required',
            'user_id'               =>  'required',
            'jumlah_transaksi'      => 'required|numeric',
            'tanggal_transaksi'     => 'required',
            'keterangan'            =>  'required',
        ];
        $text = [
            'user_id.required'     => 'Yang Bertransaksi harus diisi.',
            'jenis_transaksi.required'     => 'Kolom Jenis Transaksi harus diisi.',
            'jumlah_transaksi.required'     => 'Kolom Jumlah Transaksi harus diisi.',
            'jumlah_transaksi.numeric'      => 'Kolom Jumlah Transaksi harus berupa angka.',
            'tanggal_transaksi.required'    => 'Kolom Tanggal Transaksi harus diisi.',
            'keterangan.required'      => 'Kolom Bulan Keterangan harus diisi.',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }
        if ($request->jenis_transaksi == 'debet') {
            $jenisTransaksi = JenisTransaksi::where('id',25)->first();
        }else{
            $jenisTransaksi = JenisTransaksi::where('id',24)->first();
        }
        $inputDate = $request->tanggal_transaksi; // String YYYY-MM-DD
        $carbonDate = Carbon::parse($inputDate);
        // Menggunakan isoFormat pada objek Carbon
        $hari = $carbonDate->isoFormat('MMMM');
        $tanggal = $carbonDate->isoFormat('YYYY');
        DB::beginTransaction();

        try {
            $transaksi = TransaksiKoperasi::create([
                'jenis_transaksi_id'    =>  $jenisTransaksi->id,
                'anggota_id'            =>  $request->user_id,
                'operator_id'           =>  Auth::user()->id,
                'kategori_transaksi'       =>  $jenisTransaksi->kategori_transaksi,
                'jumlah_transaksi' =>  $request->jumlah_transaksi,
                'tanggal_transaksi' =>  $request->tanggal_transaksi,
                'bulan_transaksi'   =>  $hari,
                'tahun_transaksi'   =>  $tanggal,
            ]);

            TransaksiTelur::create([
                'transaksi_id'    =>    $transaksi->id,
                'jenis_transaksi_id'    =>  $jenisTransaksi->id,
                'jenis_transaksi'   =>  $request->jenis_transaksi,
                'user_id'            =>  $request->user_id,
                'jumlah_transaksi'      =>  $request->jumlah_transaksi,
                'tanggal'     =>  $request->tanggal_transaksi,
                'keterangan'           =>  $request->keterangan,
            ]);

            DB::commit();

            return response()->json([
                'text'  =>  'Yeay, transaksi telur berhasil disimpan',
                'url'   =>  route('transaksiTelur'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['text' =>  'Oopps, transaksi telur gagal disimpan']);
        }
    }

    public function edit(TransaksiTelur $transaksiTelur)
    {
        $jenisTransaksis = JenisTransaksi::where('id','>','4')->get();
        return view('backend.transaksiTelur.edit',[
            'transaksiTelur' =>  $transaksiTelur,
            'jenisTransaksis' =>  $jenisTransaksis,
            'anggotas' =>  $this->anggotas,
        ]);
    }

    public function update(Request $request, TransaksiTelur $transaksiTelur)
    {
        $rules = [
            'jenis_transaksi'      => 'required',
            'user_id'               =>  'required',
            'jumlah_transaksi'      => 'required|numeric',
            'tanggal_transaksi'     => 'required',
            'keterangan'            =>  'required',
        ];
        $text = [
            'user_id.required'     => 'Yang Bertransaksi harus diisi.',
            'jenis_transaksi.required'     => 'Kolom Jenis Transaksi harus diisi.',
            'jumlah_transaksi.required'     => 'Kolom Jumlah Transaksi harus diisi.',
            'jumlah_transaksi.numeric'      => 'Kolom Jumlah Transaksi harus berupa angka.',
            'tanggal_transaksi.required'    => 'Kolom Tanggal Transaksi harus diisi.',
            'keterangan.required'      => 'Kolom Bulan Keterangan harus diisi.',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        if ($request->jenis_transaksi == 'debet') {
            $jenisTransaksi = JenisTransaksi::where('id',25)->first();
        }else{
            $jenisTransaksi = JenisTransaksi::where('id',24)->first();
        }
        $inputDate = $request->tanggal_transaksi; // String YYYY-MM-DD
        $carbonDate = Carbon::parse($inputDate);
        // Menggunakan isoFormat pada objek Carbon
        $hari = $carbonDate->isoFormat('MMMM');
        $tanggal = $carbonDate->isoFormat('YYYY');
        DB::beginTransaction();

        try {
            $transaksi = TransaksiTelur::where('id',$transaksiTelur->id)->first();
            TransaksiTelur::where('id',$transaksiTelur->id)->update([
                'jenis_transaksi_id'    =>  $jenisTransaksi->id,
                'jenis_transaksi'   =>  $request->jenis_transaksi,
                'user_id'            =>  $request->user_id,
                'jumlah_transaksi'      =>  $request->jumlah_transaksi,
                'tanggal'     =>  $request->tanggal_transaksi,
                'keterangan'           =>  $request->keterangan,
            ]);

            TransaksiKoperasi::where('id',$transaksi->transaksi_id)->update([
                'jenis_transaksi_id'    =>  $jenisTransaksi->id,
                'anggota_id'            =>  $request->user_id,
                'operator_id'           =>  Auth::user()->id,
                'kategori_transaksi'       =>  $jenisTransaksi->kategori_transaksi,
                'jumlah_transaksi' =>  $request->jumlah_transaksi,
                'tanggal_transaksi' =>  $request->tanggal_transaksi,
                'bulan_transaksi'   =>  $hari,
                'tahun_transaksi'   =>  $tanggal,
            ]);

            DB::commit();

            return response()->json([
                'text'  =>  'Yeay, transaksi usaha telur berhasil diupdate',
                'url'   =>  route('transaksiTelur'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['text' =>  'Oopps, transaksi usaha telur gagal diupdate']);
        }
    }

    public function delete(Request $request, TransaksiTelur $transaksiTelur){
        try {
            // Ambil id TransaksiKoperasi
            $transaksiKoperasiId = $transaksiTelur->transaksi_id;
    
            // Hapus semua TransaksiTelur yang terkait dengan TransaksiKoperasi
            TransaksiTelur::where('transaksi_id', $transaksiKoperasiId)->delete();
    
            // Hapus TransaksiKoperasi
            $deleteKoperasi = TransaksiKoperasi::where('id', $transaksiKoperasiId)->delete();
    
            if ($deleteKoperasi) {
                return response()->json([
                    'text'  =>  'Yeay, transaksi usaha telur berhasil dihapus',
                    'url'   =>  route('transaksiTelur'),
                ]);
            } else {
                return response()->json(['text' =>  'Oopps, transaksi koperasi gagal dihapus']);
            }
        } catch (\Exception $e) {
            return response()->json(['text' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function lihatLaporan(){
  
        return view('backend/transaksiTelur.lihatLaporan');
    }

    public function cariTransaksi(Request $request){
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
        
            

            $transaksiTelurs = TransaksiTelur::with(['jenisTransaksi','user'])->whereYear('tanggal',$request->tahun)
                                            ->whereMonth('tanggal',$request->bulan)
                                            ->orderBy('tanggal','asc')
                                            ->get();
            if ($transaksiTelurs->count()>0) {
                $request->session()->put('tahunTransaksiTelur', $request->input('tahun'));
                $request->session()->put('bulanTransaksiTelur', $request->input('bulan'));
            }else{
                $request->session()->forget('tahunTransaksiTelur');
                $request->session()->forget('bulanTransaksiTelur');
            }
            return view('backend.transaksiTelur.lihatLaporan',[
                'bulan' =>  $request->bulan,
                'tahun' =>  $request->tahun,
                'transaksiTelurs' =>  $transaksiTelurs,
            ]);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Oooopps, mohon maaf ada kesalahan',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function exportData(Request $request)
    {
        // Ambil inputan dari variabel sementara (session)
        $tahunTransaksiTelur = $request->session()->get('tahunTransaksiTelur');
        $bulanTransaksiTelur = $request->session()->get('bulanTransaksiTelur');
        
        // Buat query berdasarkan inputan
        $query = TransaksiTelur::query();
        if ($tahunTransaksiTelur && $bulanTransaksiTelur) {
            $query->with(['jenisTransaksi', 'user'])
                ->whereYear('tanggal', $tahunTransaksiTelur)
                ->whereMonth('tanggal', $bulanTransaksiTelur)
                ->orderBy('tanggal', 'asc');
        }

        $data = $query->get();

        return Excel::download(
            new TransaksiTelurExport($data, $bulanTransaksiTelur, $tahunTransaksiTelur),
            'laporan-transaksi-usaha-telur-' . $bulanTransaksiTelur . '-' . $tahunTransaksiTelur . '.xlsx'
        );
    }

    public function exportDataPdf(Request $request){
        // Ambil inputan dari variabel sementara (session)
        $tahunTransaksiTelur = $request->session()->get('tahunTransaksiTelur');
        $bulanTransaksiTelur = $request->session()->get('bulanTransaksiTelur');
        
        // Buat query berdasarkan inputan
        $query = TransaksiTelur::query();
        if ($tahunTransaksiTelur && $bulanTransaksiTelur) {
            $query->with(['jenisTransaksi', 'user'])
                ->whereYear('tanggal', $tahunTransaksiTelur)
                ->whereMonth('tanggal', $bulanTransaksiTelur)
                ->orderBy('tanggal', 'asc');
        }

        $data = $query->get();
        $pdf = PDF::loadView('backend.transaksiTelur.cetakPdf',[
            'transaksiTelurs' =>  $data,
            'tahun' =>  $tahunTransaksiTelur,
            'bulan' =>  $bulanTransaksiTelur,
        ]);
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('transaksi-usaha-telur-'.$bulanTransaksiTelur . '-' . $tahunTransaksiTelur.'.pdf');
    }
}
