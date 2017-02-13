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
  <h1> Carrier <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">
    <div class="col-md-12">

      {{ Form::model( $record, array('id' => 'frmRecord', 'route' => ['carrier.update', $record->_id ], 'method' => 'post', 'autocomplete' => 'off') ) }}
        <input type="hidden" name="redirectroute" value="{{ URL::route('carrier.index') }}"/>

        <!-- search form -->
        <!-- general form elements disabled -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Edit Carrier</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Carrier Name &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::text('carrier_name', null, ['id' => 'carrier_name', 'placeholder' => 'Carrier Name', 'class' => 'form-control']) }}
                  <span name="emsg-carrier_name" class="validation-error hideme"></span>
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

        </div><!-- /.box-body -->
        <!-- / Billing -->

        <!-- Invoicing -->
        <div class="box-header with-border">
          <h3 class="box-title">Customer Visibility</h3>  &nbsp; 
        </div><!-- /.box-header -->


            <div class="col-md-12">
              <div class="form-group">
                <!-- <label>Industries Served <small>(Check all that apply)</small> </label> <br />
                <span class="form-control">&nbsp;</span> -->

                <br />
                @foreach($customers as $id => $nm)
                  <?php $chk = is_array($selcusts) && in_array($id, $selcusts) ? true : false; ?>

                  <div class="col-md-3">
                    <div class="form-group">
                      {{ Form::checkbox('cust_ids[]', $id, $chk, [ 'class' => 'square-red' ]) }} {{ $nm }}
                    </div>
                  </div>

                @endforeach

              </div>
            </div>


            <div class="clr"></div>


        <div class="box-body">

            <div class="box-footer" style="padding: 15px 15px;">

              {{ Form::submit('  Save  ', ['id' => 'btnSave', 'name' => 'btnSave', 'class' => 'btn btn-primary']) }} &nbsp; 
              <input value=" Back " name="btnExit" class="btn bg-gray" type="button" onclick="window.location.href='{{ URL::route('carrier.index') }}'" />

            </div>

          
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /search form -->
      {{ Form::close() }}
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop