<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>E2E | {{ $myApp->sp_title }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    @include('includes.app.head')

    @yield('hassets')

    @yield('headscripts')

    {{ HTML::style('public/favicon.ico', array( 'rel' => 'shortcut icon' )) }}

  </head>
  <body class="skin-e2e">
    <div class="wrapper">
      
      <header class="main-header">
        @include('includes.app.top_nav')
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        @include('includes.app.side_nav')
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        @yield('content')

      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        @include('includes.app.footer')
      </footer>
    </div><!-- ./wrapper -->

    @include('includes.app.footerjs')

    @yield('lassets')

    @yield('footscripts')

    <script type="text/javascript">
      @yield('lscripts')
    </script>

    <span id="bu-loader" class="hide-me">
      <span class="message">working </span>
      <span class="bu-loader-spinner">&nbsp;</span>
    </span>

  </body>
</html>
