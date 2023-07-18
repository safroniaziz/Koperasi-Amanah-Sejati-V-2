<li class="{{ set_active('home') }}">
    <a href="{{ route('home') }}">
        <i class="fa fa-home"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="{{ set_active('jabatan') }}">
    <a href="{{ route('jabatan') }}">
        <i class="fa fa-briefcase"></i>
        <span>Data Jabatan</span>
    </a>
</li>

<li class="{{ set_active('jenisTransaksi') }}">
    <a href="{{ route('jenisTransaksi') }}">
        <i class="fa fa-exchange-alt"></i>
        <span>Data Jenis Transaksi</span>
    </a>
</li>

<li class="{{ set_active('simpananWajib') }}">
    <a href="{{ route('simpananWajib') }}">
        <i class="fa fa-coins"></i>
        <span>Simpanan Wajib</span>
    </a>
</li>

<li class="{{ set_active('pinjaman') }}">
    <a href="{{ route('pinjaman') }}">
        <i class="fa fa-coins"></i>
        <span>Pinjaman</span>
    </a>
</li>

<li class="{{ set_active('anggota') }}">
    <a href="{{ route('anggota') }}">
        <i class="fa fa-users"></i>
        <span>Data Anggota</span>
    </a>
</li>
