@extends('layouts.app')

@section('lscripts')
<!--for local scripts-->
  $(document).ready(function() {
    $("#frmRecord1").validationEngine({
      promptPosition: "topLeft",
      onValidationComplete: function(frm, res) {
        return res;
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

  @include('includes.app.formsubmitalerts')

  <div class="row">
    <div class="col-md-12">

      <!-- search form -->
      <!-- general form elements disabled -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Change Password</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
        </div><!-- /.box-header -->
        <div class="box-body">
          {{ Form::model( $record, array('id' => 'frmRecord', 'route' => 'saaccount.updatepassword', 'method' => 'post', 'autocomplete' => 'off') ) }}
            <!-- text input -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Password &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::password('password', ['id' => 'password', 'placeholder' => 'Password', 'class' => 'form-control validate[required]']) }}
                  {{ $errors->first('password', '<span class="validation-error">:message</span>') }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Confirm Password &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::password('password_confirmation', ['id' => 'password_confirmation', 'placeholder' => 'Confirm Password', 'class' => 'form-control validate[required]']) }}
                  {{ $errors->first('password_confirmation', '<span class="validation-error">:message</span>') }}
              </div>
            </div>

            <div class="clr"></div>

            <div class="box-footer" style="padding: 10px 15px;">
              {{ Form::submit('  Save  ', ['id' => 'btnSave', 'name' => 'btnSave', 'class' => 'btn btn-primary']) }} &nbsp;  &nbsp; 
            </div>

          {{ Form::close() }}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <!-- /search form -->

    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop