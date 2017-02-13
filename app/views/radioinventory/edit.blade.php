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

    $('#vendor_id').on('change', function() {

      var url = '{{ URL::route('radioinventory.vendormodels') }}';
      var vid = $(this).val();
      showActivity();
      $.get(url, { vid:vid }, function(data) {
        $('#model_id').html(data);
      });

    });

  });
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Radio Inventory <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">
    <div class="col-md-12">

      {{ Form::model( $record, array('id' => 'frmRecord', 'route' => [ 'radioinventory.update', $record->_id ], 'method' => 'post' ) ) }}
        <input type="hidden" name="redirectroute" value="{{ URL::route('radioinventory.index') }}"/>

        <!-- search form -->
        <!-- general form elements disabled -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Edit Inventory</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Vendor &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('vendor_id', $vendors, null, ['id' => 'vendor_id', 'class' => 'form-control']) }}
                  <span name="emsg-vendor_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Model &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('model_id', $models, null, ['id' => 'model_id', 'class' => 'form-control']) }}
                  <span name="emsg-model_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr"></div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Serial Number &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::text('sku', null, ['id' => 'sku', 'placeholder' => 'Serial Number', 'class' => 'form-control']) }}
                  <span name="emsg-sku" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Status</label>
                <span class="form-control" readonly>{{ $record->status }}</span>
              </div>
            </div>

            <div class="clr"></div>

          <div class="box-body">

            <div class="box-footer" style="padding: 15px 15px;">

              {{ Form::submit('  Save  ', ['id' => 'btnSave', 'name' => 'btnSave', 'class' => 'btn btn-primary']) }} &nbsp; 
              <input value=" Back " name="btnExit" class="btn bg-gray" type="button" onclick="window.location.href='{{ URL::route('radioinventory.index') }}'" />

            </div>
          
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /search form -->
      {{ Form::close() }}
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop