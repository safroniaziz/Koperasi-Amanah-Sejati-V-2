<?php

namespace App\Http\Controllers;

use App\Models\JenisTransaksi;
use App\Models\TransaksiKoperasi;
use App\Models\TransaksiLainnya;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiLainnyaController extends Controller
{
    private $anggota;

    public function __construct() {
        $this->anggota = User::where('nama_lengkap','Koperasi')->first();;
    }
    public function index(Request $request)
    {
        $nama = $request->query('nama');
        if (!empty($nama)) {
            $transaksiKoperasis = TransaksiLainnya::with(['jenisTransaksi','anggota'])
                                ->whereHas('jenisTransaksi', function($query) use ($nama) {
                                    $query->where('nama_jenis_transaksi', 'like', '%' . $nama . '%');
                                })
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        }else{
            $transaksiKoperasis = TransaksiLainnya::with(['jenisTransaksi','anggota'])->orderBy('created_at','desc')->paginate(10);
        }
        return view('backend/transaksiKoperasi.index', [
            'transaksiKoperasis'  =>  $transaksiKoperasis,
            'nama'  =>  $nama,
        ]);
    }

    public function create()
    {
        $jenisTransaksis = JenisTransaksi::where('id','>','4')->get();
        return view('backend/transaksiKoperasi.create', [
            'anggota'   =>  $this->anggota,
            'jenisTransaksis'   =>  $jenisTransaksis,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'jenis_transaksi_id'      => 'required',
            'jumlah_transaksi'      => 'required|numeric',
            'tanggal_transaksi'     => 'required',
            'bulan_transaksi'       => 'required',
            'tahun_transaksi'       => 'required|numeric|digits:4|min:1000|max:9999',
            'keterangan'            =>  'required',
        ];
        $text = [
            'jenis_transaksi_id.required'     => 'Kolom Jenis Transaksi harus diisi.',
            'jumlah_transaksi.required'     => 'Kolom Jumlah Transaksi harus diisi.',
            'jumlah_transaksi.numeric'      => 'Kolom Jumlah Transaksi harus berupa angka.',
            'tanggal_transaksi.required'    => 'Kolom Tanggal Transaksi harus diisi.',
            'bulan_transaksi.required'      => 'Kolom Bulan Transaksi harus diisi.',
            'tahun_transaksi.required'      => 'Kolom Tahun Transaksi harus diisi.',
            'tahun_transaksi.numeric'       => 'Kolom Tahun Transaksi harus berupa angka.',
            'tahun_transaksi.digits'        => 'Kolom Tahun Transaksi harus terdiri dari 4 digit.',
            'tahun_transaksi.min'           => 'Kolom Tahun Transaksi harus memiliki nilai minimal 1000.',
            'tahun_transaksi.max'           => 'Kolom Tahun Transaksi harus memiliki nilai maksimal 9999.',
            'keterangan.required'      => 'Kolom Bulan Keterangan harus diisi.',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $jenisTransaksi = JenisTransaksi::where('id',$request->jenis_transaksi_id)->first();
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
        
        $bulanTransaksi = $namaBulan[$request->bulan_transaksi];
        DB::beginTransaction();

        try {
            $transaksi = TransaksiKoperasi::create([
                'jenis_transaksi_id'    =>  $request->jenis_transaksi_id,
                'anggota_id'            =>  $this->anggota->id,
                'operator_id'           =>  Auth::user()->id,
                'kategori_transaksi'       =>  $jenisTransaksi->kategori_transaksi,
                'jumlah_transaksi' =>  $request->jumlah_transaksi,
                'tanggal_transaksi' =>  $request->tanggal_transaksi,
                'bulan_transaksi'   =>  $bulanTransaksi,
                'tahun_transaksi'   =>  $request->tahun_transaksi,
            ]);

            TransaksiLainnya::create([
                'transaksi_id'    =>  $transaksi->id,
                'jenis_transaksi_id'    =>  $request->jenis_transaksi_id,
                'anggota_id'            =>  $this->anggota->id,
                'operator_id'           =>  Auth::user()->id,
                'jumlah_transaksi'      =>  $request->jumlah_transaksi,
                'tanggal_transaksi'     =>  $request->tanggal_transaksi,
                'bulan_transaksi'   =>  $bulanTransaksi,
                'tahun_transaksi'       =>  $request->tahun_transaksi,
                'kategori_transaksi'           =>  $jenisTransaksi->kategori_transaksi,
                'keterangan'           =>  $request->keterangan,
            ]);

            DB::commit();

            return response()->json([
                'text'  =>  'Yeay, transaksi koperasi baru berhasil disimpan',
                'url'   =>  url('/transaksiKoperasi/'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['text' =>  'Oopps, transaksi koperasi gagal disimpan']);
        }
    }

    public function edit(TransaksiLainnya $transaksiKoperasi)
    {
        $jenisTransaksis = JenisTransaksi::where('id','>','4')->get();
        return view('backend.transaksiKoperasi.edit',[
            'transaksiKoperasi' =>  $transaksiKoperasi,
            'jenisTransaksis' =>  $jenisTransaksis,
            'anggota' =>  $this->anggota,
        ]);
    }

    public function update(Request $request, TransaksiLainnya $transaksiKoperasi)
    {
        $rules = [
            'jenis_transaksi_id'      => 'required',
            'jumlah_transaksi'      => 'required|numeric',
            'tanggal_transaksi'     => 'required',
            'bulan_transaksi'       => 'required',
            'tahun_transaksi'       => 'required|numeric|digits:4|min:1000|max:9999',
            'keterangan'            =>  'required',
        ];
        $text = [
            'jenis_transaksi_id.required'     => 'Kolom Jenis Transaksi harus diisi.',
            'jumlah_transaksi.required'     => 'Kolom Jumlah Transaksi harus diisi.',
            'jumlah_transaksi.numeric'      => 'Kolom Jumlah Transaksi harus berupa angka.',
            'tanggal_transaksi.required'    => 'Kolom Tanggal Transaksi harus diisi.',
            'bulan_transaksi.required'      => 'Kolom Bulan Transaksi harus diisi.',
            'tahun_transaksi.required'      => 'Kolom Tahun Transaksi harus diisi.',
            'tahun_transaksi.numeric'       => 'Kolom Tahun Transaksi harus berupa angka.',
            'tahun_transaksi.digits'        => 'Kolom Tahun Transaksi harus terdiri dari 4 digit.',
            'tahun_transaksi.min'           => 'Kolom Tahun Transaksi harus memiliki nilai minimal 1000.',
            'tahun_transaksi.max'           => 'Kolom Tahun Transaksi harus memiliki nilai maksimal 9999.',
            'keterangan.required'      => 'Kolom Bulan Keterangan harus diisi.',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $jenisTransaksi = JenisTransaksi::where('id',$request->jenis_transaksi_id)->first();
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
        
        $bulanTransaksi = $namaBulan[$request->bulan_transaksi];
        DB::beginTransaction();

        try {
            $transaksi = TransaksiLainnya::where('id',$transaksiKoperasi->id)->first();
            TransaksiLainnya::where('id',$transaksiKoperasi->id)->update([
                'jenis_transaksi_id'    =>  $request->jenis_transaksi_id,
                'operator_id'           =>  Auth::user()->id,
                'jumlah_transaksi'      =>  $request->jumlah_transaksi,
                'tanggal_transaksi'     =>  $request->tanggal_transaksi,
                'bulan_transaksi'   =>  $bulanTransaksi,
                'tahun_transaksi'       =>  $request->tahun_transaksi,
                'kategori_transaksi'           =>  $jenisTransaksi->kategori_transaksi,
                'keterangan'           =>  $request->keterangan,
            ]);

            TransaksiKoperasi::where('id',$transaksi->transaksi_id)->update([
                'jenis_transaksi_id'    =>  $request->jenis_transaksi_id,
                'operator_id'           =>  Auth::user()->id,
                'kategori_transaksi'       =>  $jenisTransaksi->kategori_transaksi,
                'jumlah_transaksi' =>  $request->jumlah_transaksi,
                'tanggal_transaksi' =>  $request->tanggal_transaksi,
                'bulan_transaksi'   =>  $bulanTransaksi,
                'tahun_transaksi'   =>  $request->tahun_transaksi,
            ]);

            DB::commit();

            return response()->json([
                'text'  =>  'Yeay, transaksi koperasi baru berhasil diupdate',
                'url'   =>  url('/transaksiKoperasi/'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['text' =>  'Oopps, transaksi koperasi gagal diupdate']);
        }
    }

    public function delete(Request $request, TransaksiLainnya $transaksiKoperasi){
        TransaksiKoperasi::where('id',$transaksiKoperasi->transaksi_id)->delete();
        $delete =  $transaksiKoperasi->delete();
        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, transaksi koperasi berhasil dihapus',
                'url'   =>  route('transaksiKoperasi'),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, transaksi koperasi gagal dihapus']);
        }
    }
}
