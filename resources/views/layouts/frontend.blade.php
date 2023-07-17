
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KOPERASI AMANAH SEJATI | @yield('subTitle')</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('layouts.partials.assets.css')
  </head>
  <body class="hold-transition skin-blue-light fixed sidebar-mini">
    <div class="preloader">
      <div class="do-loader"></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">


      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->


      <!-- =============================================== -->


        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->


    @include('layouts.partials.assets.js')
  </body>
</html>
