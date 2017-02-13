@extends('layouts.login')

@section('lscripts')
<!--for local scripts-->
  $(document).ready(function() {
    $("#frmRec").validationEngine({
      promptPosition: "topLeft",
      onValidationComplete: function(frm, res) {
        return res;
      }
    });
  });
@stop

@section('content')

  <div class="login-box">
    <div class="login-logo">
      <img id="img-logo" src="{{ asset('public/dist/img/custom/logo.png') }}"/>
      <b><small class="logo-text">Welcome to E2E’s<br />{{ $myApp->sp_title }}</small></b>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Please enter your credentials</p>

      @if($errors->has('loginerror'))
        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          {{ $errors->first('loginerror') }}
        </div>

      @endif

      {{ Form::open( array('id' => 'frmRec', 'url' => 'login', 'method' => 'post', 'autocomplete' => 'off') ) }}
        <div class="form-group has-feedback">
          {{ Form::text('username', null, ['id' => 'username', 'placeholder' => 'Username', 'class' => 'form-control validate[required]']) }}
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
          {{ $errors->first('username', '<span class="validation-error">:message</span>') }}
        </div>

        <div class="form-group has-feedback">
          {{ Form::password('password', ['id' => 'password', 'placeholder' => 'Password', 'class' => 'form-control validate[required]']) }}
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          {{ $errors->first('password', '<span class="validation-error">:message</span>') }}
        </div>

        <div class="form-group has-feedback">
          {{ Form::text('ruk', null, ['id' => 'ruk', 'placeholder' => 'RUK', 'class' => 'form-control validate[required]']) }}
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          {{ $errors->first('ruk', '<span class="validation-error">:message</span>') }}
        </div>

        <div class="row">
          <div class="col-xs-12">
            {{ Form::submit('  Login  ', ['class' => 'btn btn-primary btn-block btn-flat']) }}
          </div><!-- /.col -->
        </div>
      {{ Form::close() }}

    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->

@stop