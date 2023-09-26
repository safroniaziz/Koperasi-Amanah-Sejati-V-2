@extends('layouts.backend')
@section('subTitle','Data Roles Permission Detail')
@section('page','Data Roles Permission Detail')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-clipboard"></i>&nbsp; Data Role
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-striped" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <a href="{{ route('roles') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Role</td>
                                        <td>
                                            {{ $role->name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-7">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-clipboard"></i>&nbsp; Data Permissions
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row">
                        <form action="{{ route('roles.assign',[$role->id]) }}" method="POST">
                            {{ csrf_field() }} {{ method_field('POST') }} 
                            <div class="col-md-12 form-group">
                                <label for="">Pilih Permission</label>
                                <select name="permission_id" id="" class="form-control selectPermission">
                                    <option disabled selected>-- pilih permission --</option>
                                    @foreach ($unassignedPermissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12" style="margin-bottom:10px !important;">
                                <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Permission</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($role->permissions as $index => $permission)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                <form action="{{ route('roles.revoke',[$role->id,$permission->id]) }}" method="POST">
                                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <a class="text-danger">Data Kosong</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        $(".selectPermission").select2({
            placeholder: 'Masukan Nama Permission',
        });

    </script>
@endpush