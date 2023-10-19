<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TabelarisKeluarExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $saldo = 0;
        $formattedData = collect([]);

        foreach ($this->data as $index => $transaksi) {
            $saldo -= $transaksi['jumlah_transaksi'];
            $formattedData->push([
                'No' => $index + 1,
                'Tanggal Transaksi' => \Carbon\Carbon::parse($transaksi['tanggal_transaksi'])->isoFormat('D MMMM YYYY'),
                'Uraian' => ($transaksi['jenisTransaksi']['nama_jenis_transaksi'] ?? '') . ' - ' . $transaksi['anggota']['nama_lengkap'],
                'Keluar' => $transaksi['kategori_transaksi'] == "keluar" ? 'Rp.' . number_format($transaksi['jumlah_transaksi'], 2) : '-',
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
