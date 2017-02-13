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
    <div class="wrapper ajaxpage">
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        @yield('content')

      </div><!-- /.content-wrapper -->

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
