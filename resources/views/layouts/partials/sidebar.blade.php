@can('read-dashboard-administrator')
<li class="{{ set_active('home') }}">
    <a href="{{ route('home') }}">
        <i class="fa fa-home"></i>
        <span>Dashboard</span>
    </a>
</li>
@endcan

<li class="{{ set_active('jabatan') }}">
    <a href="{{ route('jabatan') }}">
        <i class="fa fa-home"></i>
        <span>Data Jabatan</span>
    </a>
</li>