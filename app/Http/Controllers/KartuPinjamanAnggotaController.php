<?php

namespace App\Http\Controllers;

use App\Models\AngsuranPinjaman;
use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class KartuPinjamanAnggotaController extends Controller
{
    public function index(Request $request){
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

        return view('backend.kartuPinjamanAnggota.index',[
            'anggotas'  =>  $anggotas,
            'nama'  =>  $nama,
        ]);
    }

    public function kartuPinjamanAnggota(){
        $anggota = User::where('id',auth()->user()->id)
                        ->with(['jabatan','pinjamans' => function ($query) {
                            $query->orderBy('pinjaman_ke', 'asc');
                        }])                
                        ->first();
        return view('backend/kartuPinjamanAnggota.anggota',[
            'anggota' =>  $anggota,
        ]);
    }

    public function detail(User $anggota){
        $anggota = User::where('id',$anggota->id)
                        ->with(['jabatan','pinjamans' => function ($query) {
                            $query->orderBy('pinjaman_ke', 'asc');
                        }])                
                        ->first();
        return view('backend/kartuPinjamanAnggota.detail',[
            'anggota' =>  $anggota,
        ]);
    }

    public function cetak(User $anggota, Pinjaman $pinjaman){
        $angsurans = AngsuranPinjaman::where('pinjaman_id',$pinjaman->id)->get();
        $pdf = PDF::loadView('backend.kartuPinjamanAnggota.cetak',[
            'pinjaman'    =>  $pinjaman,
            'anggota'    =>  $anggota,
            'angsurans'    =>  $angsurans,
        ]);
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('kartu_pinjaman-'.$anggota->nama_lengkap.'.pdf');
    }
}
