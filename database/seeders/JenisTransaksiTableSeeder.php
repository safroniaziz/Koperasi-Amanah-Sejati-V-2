<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTransaksiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisTransaksi = [
            'Simpanan Wajib',
            'Pinjaman',
            'Transaksi Angsuran Pokok',
            'Transaksi Angsuran Jasa',
            'Konsumsi Rapat',
            'Simpanan Pokok',
            'Angsuran Magang',
            'Bon kas pada Pihak Ketiga',
            'Transport Pembina',
            'Jilid, Fotokopi, Cetak, ATK, dll',
            'Honorarium Pengurus/ Pengawas/ Karyawan',
            'Utang ke Taspen',
            'Bunga Dana Bergulir',
            'Pajak',
            'SHU Anggota Koperasi',
            'Pengembalian Kelebihan Bunga Dana Bergulir',
            'Tarik Tunai Saldo Tabungan Bank Bengkulu',
            'Pokok Dana Bergulir',
            'Lain-lain',
            'Pengembalian Uang Talangan',
            'Pengembalian uang konsumsi',
        ];

        foreach ($jenisTransaksi as $jenis) {
            DB::table('jenis_transaksis')->insert([
                'nama_jenis_transaksi' => $jenis,
                'kategori_transaksi'    =>  'masuk',
            ]);
        }
    }
}
