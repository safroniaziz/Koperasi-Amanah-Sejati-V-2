<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use App\Models\TransaksiKoperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PinjamanController extends Controller
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
        
        return view('backend/pinjaman.index', [
            'anggotas'  =>  $anggotas,
            'nama'  =>  $nama,
        ]);
    }

    public function detail(User $anggota){
        $anggota = User::where('id',$anggota->id)
                        ->with(['jabatan','pinjamans' => function ($query) {
                            $query->orderBy('pinjaman_ke', 'asc');
                        }])                
                        ->first();
        return view('backend/pinjaman.detail',[
            'anggota' =>  $anggota,
        ]);
    }

    public function create(User $anggota)
    {
        $tahun = now()->year;
        $bulans = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        return view('backend/pinjaman.create', [
            'anggota'   =>  $anggota,
            'tahun'   =>  $tahun,
            'bulans'   =>  $bulans,
        ]);
    }

    public function store(Request $request, User $anggota)
    {
        $rules = [
            'jumlah_transaksi'          => 'required|numeric',
            'presentase_jasa'           => 'required|numeric',
            'angsuran_pokok'            => 'required|numeric',
            'angsuran_jasa'             => 'required|numeric',
            'jumlah_bulan'              => 'required|numeric',
            'bulan_mulai_angsuran'      => 'required',
            'tahun_mulai_angsuran'      => 'required|numeric|digits:4|min:1000|max:9999',
        ];
        $text = [
            'jumlah_transaksi.required'         => 'Kolom Jumlah Transaksi harus diisi.',
            'jumlah_transaksi.numeric'          => 'Kolom Jumlah Transaksi harus berupa angka.',
            'presentase_jasa.required'          => 'Kolom Presentase Jasa harus diisi.',
            'presentase_jasa.numeric'           => 'Kolom Presentase Jasa harus berupa angka.',
            'angsuran_pokok.required'            => 'Kolom Angsuran Pokok harus diisi.',
            'angsuran_pokok.numeric'             => 'Kolom Angsuran Pokok harus berupa angka.',
            'angsuran_jasa.required'             => 'Kolom Angsuran Jasa harus diisi.',
            'angsuran_jasa.numeric'              => 'Kolom Angsuran Jasa harus berupa angka.',
            'jumlah_bulan.required'              => 'Kolom Jumlah Bulan harus diisi.',
            'jumlah_bulan.numeric'               => 'Kolom Jumlah Bulan harus berupa angka.',
            'bulan_mulai_angsuran.required'      => 'Kolom Bulan Mulai Angsuran harus diisi.',
            'bulan_mulai_angsuran.numeric'       => 'Kolom Bulan Mulai Angsuran harus berupa angka.',
            'bulan_mulai_angsuran.digits'        => 'Kolom Bulan Mulai Angsuran harus terdiri dari 2 digit angka.',
            'tahun_mulai_angsuran.required'      => 'Kolom Tahun Mulai Angsuran harus diisi.',
            'tahun_mulai_angsuran.numeric'       => 'Kolom Tahun Mulai Angsuran harus berupa angka.',
            'tahun_mulai_angsuran.digits'        => 'Kolom Tahun Mulai Angsuran harus terdiri dari 4 digit angka.',
            'tahun_mulai_angsuran.min'           => 'Kolom Tahun Mulai Angsuran harus memiliki nilai minimal 1000.',
            'tahun_mulai_angsuran.max'           => 'Kolom Tahun Mulai Angsuran harus memiliki nilai maksimal 9999.',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

       
        $lastPinjaman = Pinjaman::where('anggota_id',$anggota->id)->orderBy('pinjaman_ke', 'desc')->first();
        $nextPinjamanKe = 1; // Default jika ini adalah pinjaman pertama

        if ($lastPinjaman) {
            $nextPinjamanKe = $lastPinjaman->pinjaman_ke + 1;
        }

        $operator_id = Auth::user()->id;
        DB::beginTransaction();

        try {
            $transaksi = TransaksiKoperasi::create([
                'jenis_transaksi_id'    =>  2,
                'anggota_id' => $anggota->id,
                'operator_id' => $operator_id,
                'jumlah_transaksi'  =>  $request->jumlah_transaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'bulan_transaksi' => $request->bulan_transaksi,
                'tahun_transaksi' => $request->tahun_transaksi,
                'kategori_transaksi' => 'keluar',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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
            
            $bulanMulaiAngsuran = $namaBulan[$request->bulan_mulai_angsuran];
            $bulanSelesaiAngsuran = $namaBulan[$request->bulan_selesai_angsuran];

            Pinjaman::create([
                'transaksi_id'        =>  $transaksi->id,
                'jenis_transaksi_id'        =>  2,
                'anggota_id'                =>  $anggota->id,
                'operator_id' => $operator_id,
                'jumlah_transaksi'          =>  $request->jumlah_transaksi,
                'presentase_jasa'           =>  $request->presentase_jasa,
                'angsuran_pokok'            =>  $request->angsuran_pokok,
                'angsuran_jasa'             =>  $request->angsuran_jasa,
                'jumlah_bulan'              =>  $request->jumlah_bulan,
                'bulan_mulai_angsuran'      =>  $bulanMulaiAngsuran,
                'tahun_mulai_angsuran'      =>  $request->tahun_mulai_angsuran,
                'bulan_selesai_angsuran'    =>  $bulanSelesaiAngsuran,
                'tahun_selesai_angsuran'    =>  $request->tahun_selesai_angsuran,
                'pinjaman_ke'               =>  $nextPinjamanKe,
                'is_paid'                   =>  0,
            ]);

            DB::commit();

            return response()->json([
                'text'  =>  'Yeay, pinjaman baru berhasil disimpan',
                'url'   =>  route('pinjaman.detail',[$anggota->id]),
            ]);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi
            DB::rollBack();
        
            return response()->json(['text' => 'Oopps, pinjaman gagal disimpan']);
        }
    }

    public function edit(User $anggota, Pinjaman $pinjaman)
    {
        $tahun = now()->year;
        $bulans = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $pinjamanAnggota = Pinjaman::where('id',$pinjaman->id)->with(['transaksi'])->first();
        return view('backend.pinjaman.edit',[
            'anggota'   =>  $anggota,
            'pinjamanAnggota'   =>  $pinjamanAnggota,
            'tahun'   =>  $tahun,
            'bulans'   =>  $bulans,
        ]);
    }

    public function update(Request $request, User $anggota, Pinjaman $pinjaman)
    {
        $rules = [
            'jumlah_transaksi'          => 'required|numeric',
            'presentase_jasa'           => 'required|numeric',
            'angsuran_pokok'            => 'required|numeric',
            'angsuran_jasa'             => 'required|numeric',
            'jumlah_bulan'              => 'required|numeric',
            'bulan_mulai_angsuran'      => 'required',
            'tahun_mulai_angsuran'      => 'required|numeric|digits:4|min:1000|max:9999',
        ];
        $text = [
            'jumlah_transaksi.required'         => 'Kolom Jumlah Transaksi harus diisi.',
            'jumlah_transaksi.numeric'          => 'Kolom Jumlah Transaksi harus berupa angka.',
            'presentase_jasa.required'          => 'Kolom Presentase Jasa harus diisi.',
            'presentase_jasa.numeric'           => 'Kolom Presentase Jasa harus berupa angka.',
            'angsuran_pokok.required'            => 'Kolom Angsuran Pokok harus diisi.',
            'angsuran_pokok.numeric'             => 'Kolom Angsuran Pokok harus berupa angka.',
            'angsuran_jasa.required'             => 'Kolom Angsuran Jasa harus diisi.',
            'angsuran_jasa.numeric'              => 'Kolom Angsuran Jasa harus berupa angka.',
            'jumlah_bulan.required'              => 'Kolom Jumlah Bulan harus diisi.',
            'jumlah_bulan.numeric'               => 'Kolom Jumlah Bulan harus berupa angka.',
            'bulan_mulai_angsuran.required'      => 'Kolom Bulan Mulai Angsuran harus diisi.',
            'bulan_mulai_angsuran.numeric'       => 'Kolom Bulan Mulai Angsuran harus berupa angka.',
            'bulan_mulai_angsuran.digits'        => 'Kolom Bulan Mulai Angsuran harus terdiri dari 2 digit angka.',
            'tahun_mulai_angsuran.required'      => 'Kolom Tahun Mulai Angsuran harus diisi.',
            'tahun_mulai_angsuran.numeric'       => 'Kolom Tahun Mulai Angsuran harus berupa angka.',
            'tahun_mulai_angsuran.digits'        => 'Kolom Tahun Mulai Angsuran harus terdiri dari 4 digit angka.',
            'tahun_mulai_angsuran.min'           => 'Kolom Tahun Mulai Angsuran harus memiliki nilai minimal 1000.',
            'tahun_mulai_angsuran.max'           => 'Kolom Tahun Mulai Angsuran harus memiliki nilai maksimal 9999.',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        if ($validasi->fails()) {
            return response()->json(['error'  =>  0, 'text'   =>  $validasi->errors()->first()],422);
        }

        $operator_id = Auth::user()->id;
        DB::beginTransaction();

        try {
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
            
            $bulanMulaiAngsuran = $namaBulan[$request->bulan_mulai_angsuran];
            $bulanSelesaiAngsuran = $namaBulan[$request->bulan_selesai_angsuran];

            Pinjaman::where('id',$pinjaman->id)->update([
                'operator_id'               => $operator_id,
                'jumlah_transaksi'          =>  $request->jumlah_transaksi,
                'presentase_jasa'           =>  $request->presentase_jasa,
                'angsuran_pokok'            =>  $request->angsuran_pokok,
                'angsuran_jasa'             =>  $request->angsuran_jasa,
                'jumlah_bulan'              =>  $request->jumlah_bulan,
                'bulan_mulai_angsuran'      =>  $bulanMulaiAngsuran,
                'tahun_mulai_angsuran'      =>  $request->tahun_mulai_angsuran,
                'bulan_selesai_angsuran'    =>  $bulanSelesaiAngsuran,
                'tahun_selesai_angsuran'    =>  $request->tahun_selesai_angsuran,
            ]);

            DB::commit();

            return response()->json([
                'text'  =>  'Yeay, pinjaman baru berhasil disimpan',
                'url'   =>  route('pinjaman.detail',[$anggota->id]),
            ]);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi
            DB::rollBack();
        
            return response()->json(['text' => 'Oopps, pinjaman gagal disimpan']);
        }
    }

    public function delete(User $anggota, Pinjaman $pinjaman){
        $delete =  $pinjaman->delete();

        if ($delete) {
            return response()->json([
                'text'  =>  'Yeay, transaksi pinjaman berhasil dihapus',
                'url'   =>  route('pinjaman.detail',[$anggota->id]),
            ]);
        } else {
            return response()->json(['text' =>  'Oopps, transaksi pinjaman gagal dihapus']);
        }
    }
}
