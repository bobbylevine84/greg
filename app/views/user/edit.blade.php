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

    // styled checkboxes
    //Red color scheme for iCheck
    $('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'icheckbox_square-red'
    });


  });
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> User <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">
    <div class="col-md-12">

      {{ Form::model( $record, array('id' => 'frmRecord', 'route' => ['user.update', $record->_id], 'method' => 'post', 'autocomplete' => 'off') ) }}
        <input type="hidden" name="redirectroute" value="{{ URL::route('user.index') }}"/>

        <!-- search form -->
        <!-- general form elements disabled -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Edit User</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->


            <div class="col-md-6">
              <div class="form-group">
                <label>Username &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  <span class="form-control" disabled >{{ $record->username }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>RUK </label>
                  <span class="form-control" disabled >{{ $record->ruk }}</span>
              </div>
            </div>

            <div class="clr"></div>

        </div><!-- /.box-body -->
        <!-- / Billing -->

        <!-- Account Details -->
        <div class="box-header with-border">
          <h3 class="box-title">Account Details</h3>
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="col-md-6">
              <div class="form-group">
                <label>Name &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::text('user_name', null, ['id' => 'user_name', 'placeholder' => 'Name', 'class' => 'form-control']) }}
                  <span name="emsg-user_name" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Email &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::text('user_email', null, ['id' => 'user_email', 'placeholder' => 'Email', 'class' => 'form-control']) }}
                  <span name="emsg-user_email" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr"></div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Active? &nbsp; <small><span class="fa fa-star red"></span></small></label><br/>
                {{ Form::radio('is_active', 'Yes', null, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
                {{ Form::radio('is_active', 'No', null, [ 'class' => 'square-red' ]) }} No
                <span name="emsg-is_active" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr"></div>


        </div><!-- /.box-body -->
        <!-- / Billing -->

        <!-- Account Details -->
        <div class="box-header with-border">
          <h3 class="box-title">Groups</h3>
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="col-md-12">
              <div class="form-group">

                <br />
                @foreach($groups as $id => $nm)
                  <?php $chk = is_array($selgroups) && in_array($id, $selgroups) ? true : false; ?>

                  <div class="col-md-3">
                    <div class="form-group">
                      {{ Form::checkbox('group_ids[]', $id, $chk, [ 'class' => 'square-red' ]) }} {{ $nm }}
                    </div>
                  </div>

                @endforeach

              </div>
            </div>


            <div class="clr"></div>

            <div class="box-footer" style="padding: 15px 15px;">

              {{ Form::submit('  Save  ', ['id' => 'btnSave', 'name' => 'btnSave', 'class' => 'btn btn-primary']) }} &nbsp; 
              <input value=" Back " name="btnExit" class="btn bg-gray" type="button" onclick="window.location.href='{{ URL::route('user.index') }}'" />

            </div>

          
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /search form -->
      {{ Form::close() }}
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop