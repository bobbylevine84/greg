@extends('layouts.app')

@section('lscripts')
<!--for local scripts-->
  $(document).ready(function() {
    $("#frmRecord1").validationEngine({
      promptPosition: "topLeft",
      onValidationComplete: function(frm, status) {
        //alert(status);
        //submitImportForm(frm);
        return status;
      }
    });

    // styled checkboxes
    //Red color scheme for iCheck
    $('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'icheckbox_square-red'
    });

    $('#carrier_id').on('change', function() {

      var url = '{{ URL::route('carrierinventory.carriermodels') }}';
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
  <h1> Carrier Inventory <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formsubmitalerts')

  <div class="row">
    <div class="col-md-12">

      {{ Form::model( $record, array('id' => 'frmRecord', 'route' => 'carrierinventory.saveimport', 'method' => 'post', 'files' => true ) ) }}
        <input type="hidden" name="redirectroute" value="{{ URL::route('carrierinventory.index') }}"/>

        <!-- search form -->
        <!-- general form elements disabled -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Import Inventory</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Carrier &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('carrier_id', $carriers, null, ['id' => 'carrier_id', 'class' => 'form-control']) }}
                  {{ $errors->first('carrier_id', '<span class="validation-error">:message</span>') }}
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Model &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('model_id', $models, null, ['id' => 'model_id', 'class' => 'form-control']) }}
                  {{ $errors->first('model_id', '<span class="validation-error">:message</span>') }}
              </div>
            </div>

            <div class="clr"></div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Upload File &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  <br/>
                  {{ Form::file('import_file', ['id' => 'import_file']) }}
                  {{ $errors->first('import_file', '<span class="validation-error">:message</span>') }}
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Has Header Row?</label><br/>
                  {{ Form::radio('has_header', '1', null, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
                  {{ Form::radio('has_header', '0', null, [ 'class' => 'square-red' ]) }} No
                  {{ $errors->first('has_header', '<span class="validation-error">:message</span>') }}
              </div>
            </div>

            <div class="clr"></div>

          <div class="box-body">

            <div class="box-footer" style="padding: 15px 15px;">

              {{ Form::submit('  Save  ', ['id' => 'btnSave', 'name' => 'btnSave', 'class' => 'btn btn-primary']) }} &nbsp; 
              <input value=" Back " name="btnExit" class="btn bg-gray" type="button" onclick="window.location.href='{{ URL::route('carrierinventory.index') }}'" />

            </div>
          
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /search form -->
      {{ Form::close() }}
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop