@push('scripts')
    <style>
      #ubahSesi:hover{
        color: #9FA6B2 !important;
        transition: 300ms ease-in-out;
      }
    </style>
@endpush

<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">

    <li class="dropdown user user-menu">
      <a href="{{ route('welcome') }}" style="text-transform: uppercase">
          <i class="fa fa-globe"></i>
          <span class="hidden-xs">
            Kunjungi Website
          </span>
      </a>
    </li>
    <li class="dropdown user user-menu">
      <a href="#" style="text-transform: uppercase" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-user"></i>
          <span class="hidden-xs">
              @yield('user-login')
          </span>
      </a>
    </li>
    <!-- Control Sidebar Toggle Button -->
    <li style="background:#dc3545;">
      <a data-toggle="control-sidebar" href="{{ route('logout') }}"
          onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
          <i class="fa fa-sign-out"></i>&nbsp; {{ __('Logout') }}
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
    </li>
  </ul>
</div>

@if (!empty(session()->has('nip_dosen')))
  <div class="center-navbar hidden-xs" style="display: block; text-align: left; color: white; padding: 15px; /* adjust based on your layout * margin-left: 50px; margin-right: 300px;">
    <b style="text-transform: uppercase">
      {{ session('nama_dosen') }} - {{ session('jurusan') }}&nbsp;
      |&nbsp;
      <a href="{{ route('cari_dosen.remove_session') }}" id="ubahSesi" style="color:white"><i class="fa fa-edit"></i>&nbsp;Ubah Dosen</a>
    </b>
  </div>
@endif
