<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TabelarisMasukExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    protected $modalAwal;
    protected $bulan;
    protected $tahun;

    public function __construct($data, $modalAwal, $bulan, $tahun)
    {
        $this->data = $data;
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
            'Saldo' => 'Rp.' . number_format($this->modalAwal->modal_awal) . ',',
        ]);

        $saldo = $this->modalAwal->modal_awal;

        foreach ($this->data as $index => $transaksi) {
            if ($transaksi['kategori_transaksi'] == "masuk") {
                $saldo += $transaksi['jumlah_transaksi'];
            } else {
                $saldo -= $transaksi['jumlah_transaksi'];
            }
            $formattedData->push([
                'No' => $index + 2, // No dimulai dari 2
                'Tanggal Transaksi' => \Carbon\Carbon::parse($transaksi['tanggal_transaksi'])->isoFormat('D MMMM YYYY'),
                'Uraian' => ($transaksi['jenisTransaksi']['nama_jenis_transaksi'] ?? '') . ' - ' . $transaksi['anggota']['nama_lengkap'],
                'Masuk' => $transaksi['kategori_transaksi'] == "masuk" ? 'Rp.' . number_format($transaksi['jumlah_transaksi'], 2) : '-',
                'Saldo' => 'Rp.' . number_format($saldo, 2),
            ]);
        }

        return $formattedData;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Transaksi',
            'Uraian',
            'Masuk',
            'Saldo',
        ];
    }
}
