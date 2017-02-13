<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>E2E | {{ $myApp->sp_title }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    @include('includes.login.head')

    {{ HTML::style('public/favicon.ico', array( 'rel' => 'shortcut icon' )) }}

  </head>
  <body class="login-page">

    @yield('content')

    @include('includes.login.footerjs')

    <script type="text/javascript">
      @yield('lscripts')
    </script>

  </body>
</html>