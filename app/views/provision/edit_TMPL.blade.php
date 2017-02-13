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


    $('#vendor_id').on('change', function() {
      var url = '{{ URL::route('templates.vendormodels') }}';
      var vid = $(this).val();
      showActivity();
      $.get(url, { vid:vid }, function(data) {
        $('#vendor_model_id').html(data);
        $('#vendor_model_id').trigger('change');
      });
    });

    $('#carrier_id').on('change', function() {
      var url = '{{ URL::route('templates.carriermodels') }}';
      var cid = $(this).val();
      showActivity();
      $.get(url, { cid:cid }, function(data) {
        $('#carrier_model_id').html(data);
        $('#carrier_model_id').trigger('change');
      });
    });

    $('#vendor_model_id').on('change', function() {
      var url = '{{ URL::route('templates.vendormodelfeaures') }}';
      var mid = $(this).val();
      var tmp = $('#tmpl').val();
      if(mid=='' || mid=='undefined' || mid==undefined) {
        $('#vendor_model_ftrs').html('');
        return;
      }
      showActivity();
      $.get(url, { mid:mid,tmp:tmp }, function(data) {
        $('#vendor_model_ftrs').html(data);
      });
    });

    $('#carrier_model_id').on('change', function() {
      var url = '{{ URL::route('templates.carriermodelfeaures') }}';
      var mid = $(this).val();
      var tmp = $('#tmpl').val();
      if(mid=='' || mid=='undefined' || mid==undefined) {
        $('#carrier_model_ftrs').html('');
        return;
      }
      showActivity();
      $.get(url, { mid:mid,tmp:tmp }, function(data) {
        $('#carrier_model_ftrs').html(data);
      });
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
  <h1> Template <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">
    <div class="col-md-12">

      {{ Form::model( $record, array('id' => 'frmRecord', 'route' => ['templates.update', $record->_id], 'method' => 'post' ) ) }}
        <input type="hidden" name="redirectroute" value="{{ URL::route('templates.index') }}"/>

        <!-- search form -->
        <!-- general form elements disabled -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Create New Template</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->
            @if($myApp->isSU)
              <div class="col-md-12">
                <div class="form-group">
                  <label>Customer &nbsp; <small><span class="fa fa-star red"></span></small></label>
                    {{ Form::select('customer_id', $customers, null, ['id' => 'customer_id', 'class' => 'form-control']) }}
                    <span name="emsg-customer_id" class="validation-error hideme"></span>
                </div>
              </div>
            @else
              {{ Form::hidden('customer_id', $record->customer_id) }}
            @endif

            <div class="col-md-6">
              <div class="form-group">
                <label>Template Name &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::text('tmpl_name', null, ['id' => 'tmpl_name', 'placeholder' => 'Template Name', 'class' => 'form-control']) }}
                  <span name="emsg-tmpl_name" class="validation-error hideme"></span>
                  {{ Form::hidden('tmpl', $record->_id, [ 'id' => 'tmpl' ] ) }}
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Active? &nbsp; <small><span class="fa fa-star red"></span></small></label><br/>
                {{ Form::radio('is_active', 'Yes', null, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
                {{ Form::radio('is_active', 'No', null, [ 'class' => 'square-red' ]) }} No
                <span name="emsg-is_active" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr"></div>


            <div class="col-md-12">
              <div class="form-group">
                <label>Groups with Access <small> </small> </label> <br />
  
                @foreach($groups as $rid => $rnm)
                  <?php $chk = is_array($selgroups) && in_array($rid, $selgroups) ? true : false; ?>

                  <div class="col-md-3">
                    <div class="form-group">
                      {{ Form::checkbox('grp_ids[]', $rid, $chk, [ 'class' => 'square-red' ]) }} {{ $rnm }}
                    </div>
                  </div>

                @endforeach

              </div>
            </div>

            <div class="clr"></div>

        </div><!-- /.box-body -->
        <!-- / Billing -->

        <!-- Industries -->
        <div class="box-header with-border">
          <h3 class="box-title">Vendor Details </h3>
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="col-md-6">
              <div class="form-group">
                <label>Vendor &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('vendor_id', $vendors, null, ['id' => 'vendor_id', 'class' => 'form-control']) }}
                  <span name="emsg-vendor_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Vendor Model &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('vendor_model_id', $vendormodels, null, ['id' => 'vendor_model_id', 'class' => 'form-control']) }}
                  <span name="emsg-vendor_model_id" class="validation-error hideme"></span>
              </div>
            </div>

            <h4 >Vendor Model Features </h4>

            <span id="vendor_model_ftrs">
              {{ View::make('templates._editvmfform', [ 'records' => $record->vendormodelfeatures()->isLevel1()->get(), 'vmodel' => $record->vendor_model_id ] ) }}
            </span>

            <div class="clr"></div>




        </div><!-- /.box-body -->
        <!-- / Billing -->

        <!-- Industries -->
        <div class="box-header with-border">
          <h3 class="box-title">Carrier Details </h3> (if applicable)
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="col-md-6">
              <div class="form-group">
                <label>Carrier &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('carrier_id', $carriers, null, ['id' => 'carrier_id', 'class' => 'form-control']) }}
                  <span name="emsg-carrier_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Carrier Model &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('carrier_model_id', $carriermodels, null, ['id' => 'carrier_model_id', 'class' => 'form-control']) }}
                  <span name="emsg-carrier_model_id" class="validation-error hideme"></span>
              </div>
            </div>

            <h4 class="box-title">Carrier Model Features </h4>

            <span id="carrier_model_ftrs">
              {{ View::make('templates._editcmfform', [ 'records' => $record->carriermodelfeatures()->isLevel1()->get(), 'cmodel' => $record->carrier_model_id ] ) }}
            </span>

            <div class="clr"></div>

          <div class="box-body">

            <div class="box-footer" style="padding: 15px 15px;">

              {{ Form::submit('  Save  ', ['id' => 'btnSave', 'name' => 'btnSave', 'class' => 'btn btn-primary']) }} &nbsp; 
              <input value=" Back " name="btnExit" class="btn bg-gray" type="button" onclick="window.location.href='{{ URL::route('templates.index') }}'" />

            </div>
          
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /search form -->
      {{ Form::close() }}
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop