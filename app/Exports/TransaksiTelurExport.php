<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiTelurExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    protected $bulan;
    protected $tahun;

    public function __construct(Collection $data, $bulan, $tahun)
    {
        $this->data = $data;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $saldo = 0; // Inisialisasi saldo awal

        return $this->data->map(function ($transaksi, $index) use (&$saldo) {
            return [
                'No' => $index + 1,
                'Transaksi' => $transaksi->jenisTransaksi->nama_jenis_transaksi,
                'Nama Anggota' => $transaksi->user->nama_lengkap,
                'Tanggal Transaksi' => $transaksi->tanggal,
                'Keterangan/Uraian' => $transaksi->keterangan,
                'Debet' => $transaksi->jenis_transaksi == "debet" ? 'Rp.' . number_format($transaksi->jumlah_transaksi) . '-': '',
                'Kredit' => $transaksi->jenis_transaksi == "kredit" ? 'Rp.' . number_format($transaksi->jumlah_transaksi) . '-': '',
                'Saldo' => 'Rp.' . number_format($this->hitungSaldo($transaksi->jenis_transaksi, $transaksi->jumlah_transaksi, $saldo)) . '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Transaksi',
            'Nama Anggota',
            'Tanggal Transaksi',
            'Keterangan/Uraian',
            'Debet',
            'Kredit',
            'Saldo',
        ];
    }

    protected function hitungSaldo($jenisTransaksi, $jumlahTransaksi, &$saldo)
    {
        if ($jenisTransaksi == "debet") {
            $saldo += $jumlahTransaksi;
        } elseif ($jenisTransaksi == "kredit") {
            $saldo -= $jumlahTransaksi;
        }

        return $saldo;
    }
}
