<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use App\Models\JenisTransaksi;
use App\Models\AngsuranPinjaman;
use App\Models\TransaksiKoperasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AngsuranPinjamanController extends Controller
{
    public function angsuran(User $anggota, Pinjaman $pinjaman){
        $angsurans = AngsuranPinjaman::where('pinjaman_id',$pinjaman->id)
                                    ->where('anggota_id',$anggota->id)
                                    ->orderBy('angsuran_ke','desc')
                                    ->get();
        return view('backend/angsuran.index',[
            'anggota' =>  $anggota,
            'pinjaman' =>  $pinjaman,
            'angsurans' =>  $angsurans,
        ]);
    }

    public function store(Request $request, User $anggota, Pinjaman $pinjaman)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_transaksi'     => 'required',
            // 'bulan_transaksi'       => 'required',
            'angsuran_pokok'       => 'required',
            'angsuran_jasa'       => 'required',
            // 'bulan_transaksi'       => 'required',
            // 'tahun_transaksi'       => 'required|numeric|digits:4|min:1000|max:9999',
        ], [
            'tanggal_transaksi.required' => 'Kolom Tanggal Transaksi harus diisi.',
            // 'bulan_transaksi.required' => 'Kolom Bulan Transaksi harus diisi.',
            'angsuran_pokok.required' => 'Kolom Angsuran Pokok harus diisi.',
            'angsuran_jasa.required' => 'Kolom Angsuran Jasa harus diisi.',
            // 'tahun_transaksi.required' => 'Kolom Tahun Transaksi harus diisi.',
            // 'tahun_transaksi.numeric' => 'Kolom Tahun Transaksi harus berupa angka.',
            // 'tahun_transaksi.digits' => 'Kolom Tahun Transaksi harus terdiri dari 4 digit angka.',
            // 'tahun_transaksi.min' => 'Kolom Tahun Transaksi harus memiliki nilai minimal 1000.',
            // 'tahun_transaksi.max' => 'Kolom Tahun Transaksi harus memiliki nilai maksimal 9999.',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            $operator_id = Auth::user()->id;
            $anggota_id = $anggota->id;
            $pinjaman_id = $pinjaman->id;

            $commonData = [
                'anggota_id' => $anggota->id,
                'operator_id' => $operator_id,
                'kategori_transaksi' => 'masuk',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $angsuranTerakhir = AngsuranPinjaman::where('anggota_id', $anggota_id)->where('pinjaman_id', $pinjaman_id)->count();
            
            $tanggal_transaksi_awal = $request->tanggal_transaksi;
            $carbonDate = \Carbon\Carbon::parse($tanggal_transaksi_awal);

            for ($i = 0; $i < $request->jumlah_bulan; $i++) {
                $tanggal_transaksi = $carbonDate->format('Y-m-d');
                $bulan_transaksi = $carbonDate->format('m');
                $tahun_transaksi = $carbonDate->format('Y');

                $selisih_bulan = Carbon::parse($tanggal_transaksi_awal)->diffInMonths(Carbon::parse($tanggal_transaksi));
                $bulan_transaksi = $selisih_bulan + 1;
            
                $transaksi_pokok = TransaksiKoperasi::create(array_merge([
                    'jenis_transaksi_id' => 3,
                    'tanggal_transaksi' => $tanggal_transaksi,
                    'bulan_transaksi' => $carbonDate->isoFormat('MMMM'),
                    'tahun_transaksi' => $tahun_transaksi,
                    'jumlah_transaksi' => $request->angsuran_pokok,
                ], $commonData));
            
                $transaksi_jasa = TransaksiKoperasi::create(array_merge([
                    'jenis_transaksi_id' => 4,
                    'tanggal_transaksi' => $tanggal_transaksi,
                    'bulan_transaksi' => $carbonDate->isoFormat('MMMM'),
                    'tahun_transaksi' => $tahun_transaksi,
                    'jumlah_transaksi' => $request->angsuran_jasa,
                ], $commonData));
            
                AngsuranPinjaman::create([
                    'transaksi_pokok_id' => $transaksi_pokok->id,
                    'transaksi_jasa_id' => $transaksi_jasa->id,
                    'pinjaman_id' => $pinjaman_id,
                    'anggota_id' => $anggota_id,
                    'angsuran_pokok' => $request->angsuran_pokok,
                    'angsuran_jasa' => $request->angsuran_jasa,
                    'tanggal_transaksi' => $tanggal_transaksi,
                    'bulan_transaksi' => $carbonDate->isoFormat('MMMM'),
                    'tahun_transaksi' => $tahun_transaksi,
                    'angsuran_ke' => $angsuranTerakhir + $i + 1,
                ]);
            
                // Tambah satu bulan untuk iterasi selanjutnya
                $carbonDate->addMonth()->startOfMonth();
            }

            DB::commit();
            return response()->json([
                'text'  =>  'Yeay, transaksi angsuran berhasil disimpan',
                'url'   =>  route('angsuran',[$anggota->id,$pinjaman->id]),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['text' =>  'Oopps, transaksi angsuran gagal disimpan']);
        }
    }

    public function edit(AngsuranPinjaman $angsuran){
        return $angsuran;
    }

    public function update(Request $request, User $anggota, Pinjaman $pinjaman){
        $validator = Validator::make($request->all(), [
            'tanggal_transaksi'     => 'required',
            // 'bulan_transaksi'       => 'required',
            'angsuran_pokok'       => 'required',
            'angsuran_jasa'       => 'required',
            // 'bulan_transaksi'       => 'required',
            // 'tahun_transaksi'       => 'required|numeric|digits:4|min:1000|max:9999',
        ], [
            'tanggal_transaksi.required' => 'Kolom Tanggal Transaksi harus diisi.',
            // 'bulan_transaksi.required' => 'Kolom Bulan Transaksi harus diisi.',
            'angsuran_pokok.required' => 'Kolom Angsuran Pokok harus diisi.',
            'angsuran_jasa.required' => 'Kolom Angsuran Jasa harus diisi.',
            // 'tahun_transaksi.required' => 'Kolom Tahun Transaksi harus diisi.',
            // 'tahun_transaksi.numeric' => 'Kolom Tahun Transaksi harus berupa angka.',
            // 'tahun_transaksi.digits' => 'Kolom Tahun Transaksi harus terdiri dari 4 digit angka.',
            // 'tahun_transaksi.min' => 'Kolom Tahun Transaksi harus memiliki nilai minimal 1000.',
            // 'tahun_transaksi.max' => 'Kolom Tahun Transaksi harus memiliki nilai maksimal 9999.',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => 0, 'text' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            $tanggal_transaksi_awal = $request->tanggal_transaksi;
            $carbonDate = \Carbon\Carbon::parse($tanggal_transaksi_awal);

            $tanggal_transaksi = $carbonDate->format('Y-m-d');
            $bulan_transaksi = $carbonDate->format('m');
            $tahun_transaksi = $carbonDate->format('Y');

            $angsuran = AngsuranPinjaman::where('id',$request->angsuran_id)->first();
            TransaksiKoperasi::where('id',$angsuran->transaksi_pokok_id)->update([
                'jumlah_transaksi'  =>  $request->angsuran_pokok,
                'tanggal_transaksi' => $tanggal_transaksi,
                'bulan_transaksi' => $carbonDate->isoFormat('MMMM'),
                'tahun_transaksi' => $tahun_transaksi,
            ]);
            TransaksiKoperasi::where('id',$angsuran->transaksi_jasa_id)->update([
                'jumlah_transaksi'  =>  $request->angsuran_jasa,
                'tanggal_transaksi' => $tanggal_transaksi,
                'bulan_transaksi' => $carbonDate->isoFormat('MMMM'),
                'tahun_transaksi' => $tahun_transaksi,
            ]);
            AngsuranPinjaman::where('id',$request->angsuran_id)->update([
                'pinjaman_id' => $pinjaman->id,
                'anggota_id' => $anggota->id,
                'angsuran_pokok' => $request->angsuran_pokok,
                'angsuran_jasa' => $request->angsuran_jasa,
                'tanggal_transaksi' => $tanggal_transaksi,
                'bulan_transaksi' => $carbonDate->isoFormat('MMMM'),
                'tahun_transaksi' => $tahun_transaksi,
            ]);

            DB::commit();
            return response()->json([
                'text'  =>  'Yeay, transaksi angsuran berhasil diubah',
                'url'   =>  route('angsuran',[$anggota->id,$pinjaman->id]),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['text' =>  'Oopps, transaksi angsuran gagal diubah']);
        }
    }

    public function delete(AngsuranPinjaman $angsuran){
        DB::beginTransaction();
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            TransaksiKoperasi::where('id',$angsuran->transaksi_pokok_id)->delete();
            TransaksiKoperasi::where('id',$angsuran->transaksi_jasa_id)->delete();
            $delete =  $angsuran->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::commit();
            return response()->json([
                'text'  =>  'Yeay, transaksi angsuran berhasil dihapus',
                'url'   =>  route('angsuran',[$angsuran->anggota_id,$angsuran->pinjaman_id]),
            ]);
      
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['text' =>  'Oopps, transaksi angsuran gagal dihapus']);
        }
    }
}
