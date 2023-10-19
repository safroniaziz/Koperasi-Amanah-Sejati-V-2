<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class BukuKasPembantuExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $transaksis;
    protected $modalAwal;
    protected $bulan;
    protected $tahun;

    public function __construct($transaksis, $modalAwal, $bulan, $tahun)
    {
        $this->transaksis = $transaksis;
        $this->modalAwal = $modalAwal;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $formattedData = collect([]);

        // Tambahkan data untuk "Modal Awal" di awal
        $formattedData->push([
            'No' => 1,
            'Tanggal Transaksi' => '1 ' . \Carbon\Carbon::createFromDate(null, $this->bulan)->locale('id')->monthName . ' ' . $this->tahun,
            'Uraian' => 'Modal Awal',
            'Masuk' => 'Rp.' . number_format($this->modalAwal->modal_awal) . ',',
            'Keluar' => '-',
            'Saldo' => 'Rp.' . number_format($this->modalAwal->modal_awal) . ',',
        ]);

        foreach ($this->transaksis as $index => $transaksi) {
            $formattedData->push([
                'No' => $index + 2, // No dimulai dari 2
                'Tanggal Transaksi' => \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->isoFormat('D MMMM YYYY'),
                'Uraian' => ($transaksi->jenisTransaksi ? $transaksi->jenisTransaksi->nama_jenis_transaksi : '') . ' - ' . $transaksi->anggota->nama_lengkap,
                'Masuk' => $transaksi->kategori_transaksi == "masuk" ? 'Rp.' . number_format($transaksi->jumlah_transaksi, 2) : '-',
                'Keluar' => $transaksi->kategori_transaksi == "keluar" ? 'Rp.' . number_format($transaksi->jumlah_transaksi, 2) : '-',
                'Saldo' => $transaksi->kategori_transaksi == "masuk" ? 'Rp.' . number_format($transaksi->jumlah_transaksi + $this->modalAwal->modal_awal, 2) : 'Rp.' . number_format($this->modalAwal->modal_awal - $transaksi->jumlah_transaksi, 2),
            ]);

            if ($transaksi->kategori_transaksi == "masuk") {
                $this->modalAwal->modal_awal = $transaksi->jumlah_transaksi + $this->modalAwal->modal_awal;
            } else {
                $this->modalAwal->modal_awal = $this->modalAwal->modal_awal - $transaksi->jumlah_transaksi;
            }
        }

        return $formattedData;
    }
}
