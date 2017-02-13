@extends('layouts.app')

@section('lscripts')
<!--for local scripts-->
  $(document).ready(function() {

    // styled checkboxes
    //Red color scheme for iCheck
    $('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'icheckbox_square-red'
    });

    var initcid = $('#carrier_id').val();
    if(initcid=='' || initcid=='undefined' || initcid==undefined) $('.carrier-flds').hide();
    else $('.carrier-flds').show();

    $('input[type!="button"], select').attr('disabled', true);

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
            <h3 class="box-title">View Template</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->
            @if($myApp->isSU)
              <div class="col-md-12">
                <div class="form-group">
                  <label>Customer &nbsp; <small></small></label>
                    {{ Form::select('customer_id', $customers, null, ['id' => 'customer_id', 'class' => 'form-control']) }}
                    <span name="emsg-customer_id" class="validation-error hideme"></span>
                </div>
              </div>
            @else
              {{ Form::hidden('customer_id', $record->customer_id) }}
            @endif

            <div class="col-md-6">
              <div class="form-group">
                <label>Template Name &nbsp; <small></small></label>
                  {{ Form::text('tmpl_name', null, ['id' => 'tmpl_name', 'placeholder' => 'Template Name', 'class' => 'form-control']) }}
                  <span name="emsg-tmpl_name" class="validation-error hideme"></span>
                  {{ Form::hidden('tmpl', $record->_id, [ 'id' => 'tmpl' ] ) }}
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Active? &nbsp; <small></small></label><br/>
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
                <label>Vendor &nbsp; <small></small></label>
                  {{ Form::select('vendor_id', $vendors, null, ['id' => 'vendor_id', 'class' => 'form-control']) }}
                  <span name="emsg-vendor_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Vendor Model &nbsp; <small></small></label>
                  {{ Form::select('vendor_model_id', $vendormodels, null, ['id' => 'vendor_model_id', 'class' => 'form-control']) }}
                  <span name="emsg-vendor_model_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Serial Number Required? &nbsp; <small></small></label><br/>
                {{ Form::radio('need_vendor_sku', 'Yes', null, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
                {{ Form::radio('need_vendor_sku', 'No', null, [ 'class' => 'square-red' ]) }} No
                <span name="emsg-need_vendor_sku" class="validation-error hideme"></span>
              </div>
            </div>

			<div class="clr"></div>

            <h4 >Vendor Model Features </h4>

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
                <label>Carrier Model &nbsp; <small class="carrier-flds hide-me"></small></label>
                  {{ Form::select('carrier_model_id', $carriermodels, null, ['id' => 'carrier_model_id', 'class' => 'form-control']) }}
                  <span name="emsg-carrier_model_id" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Serial Number Required? &nbsp; <small></small></label><br/>
                {{ Form::radio('need_carrier_sku', 'Yes', null, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
                {{ Form::radio('need_carrier_sku', 'No', null, [ 'class' => 'square-red' ]) }} No
                <span name="emsg-need_carrier_sku" class="validation-error hideme"></span>
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