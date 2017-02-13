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
      if(cid=='' || cid=='undefined' || cid==undefined) $('.carrier-flds').hide();
      else $('.carrier-flds').show();
      showActivity();
      $.get(url, { cid:cid }, function(data) {
        $('#carrier_model_id').html(data);
        $('#carrier_model_id').trigger('change');
      });
    });

    $('#vendor_model_id').on('change', function() {
      var url = '{{ URL::route('templates.vendormodelallfeatures') }}';
      var mid = $(this).val();
      var tmp = $('#tmpl').val();
      if(mid=='' || mid=='undefined' || mid==undefined) {
        $('#vendor_model_ftrs').html('');
        return;
      }
      showActivity();
      $.get(url, { mid:mid,tmp:tmp }, function(data) {
        $('#vendor_model_ftr_list').html(data);
        $('#vendor_model_ftrs').html('');
      });
    });

    $('#carrier_model_id').on('change', function() {
      var url = '{{ URL::route('templates.carriermodelallfeatures') }}';
      var mid = $(this).val();
      var tmp = $('#tmpl').val();
      if(mid=='' || mid=='undefined' || mid==undefined) {
        $('#carrier_model_ftrs').html('');
        return;
      }
      showActivity();
      $.get(url, { mid:mid,tmp:tmp }, function(data) {
        $('#carrier_model_ftr_list').html(data);
        $('#carrier_model_ftrs').html('');
      });
    });

    $('#addvmf').on('click', function() {
      var url = '{{ URL::route('templates.vendormodelfeature') }}';
      var fid = $('#vendor_model_ftr_list').val();
      var knt = $('.mvfid_' + fid).length;

      showActivity();
      $.get(url, { fid:fid,knt:knt }, function(data) {
        if(data=='UNIQUEERROR') alert("Unique Feature. Can't add more than once.");
        else $('#vendor_model_ftrs').append(data);
      });
    });

    $('#addcmf').on('click', function() {
      var url = '{{ URL::route('templates.carriermodelfeature') }}';
      var fid = $('#carrier_model_ftr_list').val();
      var knt = $('.mcfid_' + fid).length;

      showActivity();
      $.get(url, { fid:fid,knt:knt }, function(data) {
        if(data=='UNIQUEERROR') alert("Unique Feature. Can't add more than once.");
        else $('#carrier_model_ftrs').append(data);
      });
    });


    // styled checkboxes
    //Red color scheme for iCheck
    $('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'icheckbox_square-red'
    });

    var initcid = $('#carrier_id').val();
    if(initcid=='' || initcid=='undefined' || initcid==undefined) $('.carrier-flds').hide();
    else $('.carrier-flds').show();

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
            <h3 class="box-title">Edit Template</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
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
                  <i>(Slashes are prohibited. Use dashes or spaces instead.)</i>
                  {{ Form::text('tmpl_name', null, ['id' => 'tmpl_name', 'placeholder' => 'Template Name', 'class' => 'form-control']) }}
                  <span name="emsg-tmpl_name" class="validation-error hideme"></span>
                  {{ Form::hidden('tmpl', $record->_id, [ 'id' => 'tmpl' ] ) }}
                  <i>We recommend naming your templates according to function or radio/feature set to make provisioning easier. For 
example, ‘JohnsonField‐2eth‐1cell‐1ser’.</i>
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
  
                @if($groups)

                  @foreach($groups as $rid => $rnm)
                    <?php $chk = is_array($selgroups) && in_array($rid, $selgroups) ? true : false; ?>

                    <div class="col-md-3">
                      <div class="form-group">
                        {{ Form::checkbox('grp_ids[]', $rid, $chk, [ 'class' => 'square-red' ]) }} {{ $rnm }}
                      </div>
                    </div>

                  @endforeach
                @else
                  No Groups found.
                @endif

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

            <div class="col-md-4">
              <div class="form-group">
                <label>Vendor &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('vendor_id', $vendors, null, ['id' => 'vendor_id', 'class' => 'form-control']) }}
                  <span name="emsg-vendor_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Vendor Model &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('vendor_model_id', $vendormodels, null, ['id' => 'vendor_model_id', 'class' => 'form-control']) }}
                  <span name="emsg-vendor_model_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Serial Number Required? &nbsp; <small><span class="fa fa-star red"></span></small></label><br/>
                {{ Form::radio('need_vendor_sku', 'Yes', null, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
                {{ Form::radio('need_vendor_sku', 'No', null, [ 'class' => 'square-red' ]) }} No
                <span name="emsg-need_vendor_sku" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr"></div>

            <h4 >Vendor Model Features </h4>

            <div class="col-md-11">
              <div class="form-group">
                <label>Vendor Model Feature List &nbsp;</label>
                  {{ Form::select('vendor_model_ftr_list', $vendormodelftrs, null, ['id' => 'vendor_model_ftr_list', 'class' => 'form-control']) }}
                  <span name="emsg-vendor_model_ftr_list" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-1">
              <div class="form-group">
                <label> &nbsp;</label>
                  <input value=" Add " name="btnaddvmf" id="addvmf" class="addvmf btn btn-primary" type="button" />                  
              </div>
            </div>

            <div class="clr"></div>

            <span id="vendor_model_ftrs">
              {{ View::make('templates._editvmfform', [ 'records' => $record->vendormodelfeatures()->isLevel1()->get(), 'vmodel' => $record->vendor_model_id, 'ft_lbl_part' => $ft_lbl_part, 'ft_fld_part' => $ft_fld_part ] ) }}
            </span>

            <div class="clr"></div>

        </div><!-- /.box-body -->
        <!-- / Billing -->

        <!-- Industries -->
        <div class="box-header with-border">
          <h3 class="box-title">Carrier Details </h3> (if applicable)
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="col-md-4">
              <div class="form-group">
                <label>Carrier </label>
                  {{ Form::select('carrier_id', $carriers, null, ['id' => 'carrier_id', 'class' => 'form-control']) }}
                  <span name="emsg-carrier_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Carrier Model &nbsp; <small class="carrier-flds hide-me"><span class="fa fa-star red"></span></small></label>
                  {{ Form::select('carrier_model_id', $carriermodels, null, ['id' => 'carrier_model_id', 'class' => 'form-control']) }}
                  <span name="emsg-carrier_model_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Serial Number Required? &nbsp; <small><span class="fa fa-star red"></span></small></label><br/>
                {{ Form::radio('need_carrier_sku', 'Yes', null, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
                {{ Form::radio('need_carrier_sku', 'No', null, [ 'class' => 'square-red' ]) }} No
                <span name="emsg-need_carrier_sku" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-11">
              <div class="form-group">
                <label>Carrier Model Feature List &nbsp;</label>
                  {{ Form::select('carrier_model_ftr_list', $carriermodelftrs, null, ['id' => 'carrier_model_ftr_list', 'class' => 'form-control']) }}
                  <span name="emsg-carrier_model_ftr_list" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-1">
              <div class="form-group">
                <label> &nbsp;</label>
                  <input value=" Add " name="btnaddvmf" id="addcmf" class="addvmf btn btn-primary" type="button" />                  
              </div>
            </div>

            <div class="clr"></div>

            <h4 class="box-title">Carrier Model Features </h4>

            <span id="carrier_model_ftrs">
              {{ View::make('templates._editcmfform', [ 'records' => $record->carriermodelfeatures()->isLevel1()->get(), 'cmodel' => $record->carrier_model_id, 'ft_lbl_part' => $ft_lbl_part, 'ft_fld_part' => $ft_fld_part ] ) }}
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