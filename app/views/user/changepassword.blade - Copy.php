@extends('layouts.app')

@section('lscripts')
<!--for local scripts-->
  $(document).ready(function() {
    $("#frmRecord").validationEngine({
      promptPosition: "topLeft",
      onValidationComplete: function(frm, status) {
        //alert(status);
        submitForm(frm);
        return false;
      }
    });

  });
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Change Password <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">
    <div class="col-md-12">

      {{ Form::model( $record, array('id' => 'frmRecord', 'route' => 'user.updatepassword', 'method' => 'post', 'autocomplete' => 'off') ) }}
        <input type="hidden" name="redirectroute" value="{{ URL::route('user.myaccount') }}"/>

        <!-- general form elements disabled -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Change Password</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Password &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::password('password', ['id' => 'password', 'placeholder' => 'Password', 'class' => 'form-control']) }}
                  <span name="emsg-password" class="validation-error hideme"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Confirm Password &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::password('password_confirmation', ['id' => 'password_confirmation', 'placeholder' => 'Confirm Password', 'class' => 'form-control']) }}
                  <span name="emsg-password_confirmation" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr"></div>

            <div class="box-footer" style="padding: 15px 15px;">
              {{ Form::submit('  Save  ', ['id' => 'btnSave', 'name' => 'btnSave', 'class' => 'btn btn-primary']) }} &nbsp; 
              <input value=" Back " name="btnExit" class="btn bg-gray" type="button" onclick="window.location.href='{{ URL::route('user.myaccount') }}'" />
            </div>
          
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /search form -->
      {{ Form::close() }}
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop