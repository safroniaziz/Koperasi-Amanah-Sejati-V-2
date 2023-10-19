@can('dashboard')
    <li class="{{ set_active('home') }}">
        <a href="{{ route('home') }}">
            <i class="fa fa-window-restore"></i>
            <span>Dashboard</span>
        </a>
    </li>
@endcan

@can('jabatan')
<li class="{{ set_active('jabatan') }}">
    <a href="{{ route('jabatan') }}">
        <i class="fa fa-briefcase"></i>
        <span>Data Jabatan</span>
    </a>
</li>
@endcan

@can('jenis-transaksi')
    <li class="{{ set_active('jenisTransaksi') }}">
        <a href="{{ route('jenisTransaksi') }}">
            <i class="fa fa-exchange-alt"></i>
            <span>Data Jenis Transaksi</span>
        </a>
    </li>
@endcan

@can('transaksi-koperasi')
    <li class="header" style="font-weight:bold;">TRANSAKSI</li>
@endcan
@can('simpanan-wajib')
    @if (auth()->user()->hasRole('Operator'))
        <li class="{{ set_active(['simpananWajib','simpananWajib.detail']) }}">
            <a href="{{ route('simpananWajib') }}">
                <i class="fa fa-wallet"></i>
                <span>Simpanan Wajib</span>
            </a>
        </li>
    @else
        <li class="{{ set_active(['simpananWajibAnggota']) }}">
            <a href="{{ route('simpananWajibAnggota') }}">
                <i class="fa fa-wallet"></i>
                <span>Simpanan Wajib</span>
            </a>
        </li>
    @endif
@endcan

@can('pinjaman')
    <li class="{{ set_active(['pinjaman','pinjaman.detail','pinjaman.create','pinjaman.edit','angsuran']) }}">
        <a href="{{ route('pinjaman') }}">
            <i class="fa fa-coins"></i>
            <span>Pinjaman</span>
        </a>
    </li>
@endcan

@can('transaksi-koperasi')
    <li class="{{ set_active('transaksiKoperasi') }}">
        <a href="{{ route('transaksiKoperasi') }}">
            <i class="fa fa-chart-bar"></i>
            <span>Transaksi Koperasi</span>
        </a>
    </li>
@endcan

@can('modal-awal')
    <li class="header" style="font-weight:bold;">LAPORAN</li>
    <li class="{{ set_active('modalAwal') }}">
        <a href="{{ route('modalAwal') }}">
            <i class="fa fa-money-bill"></i>
            <span>Manajemen Modal Awal</span>
        </a>
    </li>
@endcan

@can('buku-kas-pembantu')
    <li class="{{ set_active(['kasPembantu','kasPembantu.cariBukuKas']) }}">
        <a href="{{ route('kasPembantu') }}">
            <i class="fa fa-book"></i>
            <span>Buku Kas Pembantu</span>
        </a>
    </li>
@endcan

@can('kartu-pinjaman')
    @if (auth()->user()->hasRole('Operator'))
        <li class="{{ set_active(['kartuPinjaman','kartuPinjaman.detail']) }}">
            <a href="{{ route('kartuPinjaman') }}">
                <i class="fa fa-id-card"></i>
                <span>Kartu Pinjaman Anggota</span>
            </a>
        </li>
    @else
        <li class="{{ set_active(['kartuPinjaman.anggota']) }}">
            <a href="{{ route('kartuPinjaman.anggota') }}">
                <i class="fa fa-id-card"></i>
                <span>Kartu Pinjaman Anggota</span>
            </a>
        </li>
    @endif
@endcan

@can('tabelaris-masuk')
    <li class="{{ set_active(['tabelarisMasuk','tabelarisMasuk.cari']) }}">
        <a href="{{ route('tabelarisMasuk') }}">
            <i class="fa fa-arrow-circle-left"></i>
            <span>Tabelaris Kas Masuk</span>
        </a>
    </li>
@endcan

@can('tabelaris-keluar')
    <li class="{{ set_active(['tabelarisKeluar','tabelarisKeluar.cari']) }}">
        <a href="{{ route('tabelarisKeluar') }}">
            <i class="fa fa-arrow-circle-right"></i>
            <span>Tabelaris Kas Keluar</span>
        </a>
    </li>
@endcan

@can('shu-anggota')
    @if (auth()->user()->hasRole('Operator'))
        <li class="{{ set_active(['shu','shu.detail']) }}">
            <a href="{{ route('shu') }}">
                <i class="fa fa-chart-line"></i>
                <span>SHU Anggota</span>
            </a>
        </li>
    @else
        <li class="{{ set_active(['shu.anggota']) }}">
            <a href="{{ route('shu.anggota') }}">
                <i class="fa fa-chart-line"></i>
                <span>SHU Anggota</span>
            </a>
        </li>
    @endif
@endcan

@can('manajemen-users')
    <li class="header" style="font-weight:bold;">PENGATURAN</li>

    <li class="treeview {{ set_active([
        'permissions',
        'roles',
        'anggota','anggota_create','anggota_edit',
        'operator','operator_create','operator_edit',
    ]) }}">
        <a href="#">
            <i class="fa fa-user-cog"></i> <span>Manajemen Users</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu " style="padding-left:25px;">
            <li class="{{ set_active(['permissions']) }}"><a href="{{ route('permissions') }}"><i class="fa fa-circle-o"></i>Permissions</a></li>
            <li class="{{ set_active(['roles']) }}"><a href="{{ route('roles') }}"><i class="fa fa-circle-o"></i>Roles</a></li>
            <li class="{{ set_active(['anggota','anggota.create','anggota.edit']) }}"><a href="{{ route('anggota') }}"><i class="fa fa-circle-o"></i>Data Anggota</a></li>
            <li class="{{ set_active(['operator','operator.create','operator.edit']) }}"><a href="{{ route('operator') }}"><i class="fa fa-circle-o"></i>Data Operator</a></li>
        </ul>
    </li>
@endcan

<li>
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out text-danger"></i>
        <span>
            {{ __('Logout') }}
        </span>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>
