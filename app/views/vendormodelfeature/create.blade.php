@extends('layouts.app')

@section('lscripts')

  var childKount = $('input[type="hidden"][name^="keys["]').length;
  var childmouldurl = '{{ URL::route('masterdata.newchildmouldvendormodelfeature') }}';
//alert(childKount);

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


    $('#btnAdd').click(function() {

      if(confirm('Add a new child feature?')) {
        showActivity();
        $.get(childmouldurl, { ck:childKount }, function(data) {
          //if(data.status == 'success') { }
          $('.clr-fields').last().after(data);
          stylizeRdnChk();
          childKount++;
        });
      }

    });


    // styled checkboxes
    stylizeRdnChk();

  });

  function stylizeRdnChk() {
    // styled checkboxes
    //Red color scheme for iCheck
    $('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'icheckbox_square-red'
    });
  }

@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Vendor Model Feature <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">
    <div class="col-md-12">

      {{ Form::model( $record, array('id' => 'frmRecord', 'route' => 'masterdata.storevendormodelfeature', 'method' => 'post' ) ) }}
        <input type="hidden" name="redirectroute" value="{{ URL::route('masterdata.vendormodelfeature') }}"/>

        <!-- search form -->
        <!-- general form elements disabled -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Create New Feature</h3> &nbsp; (<small><span class="fa fa-star red"> required field</span></small>)
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Feature Name &nbsp; <small><span class="fa fa-star red"></span></small></label>
                  {{ Form::text('ft_label', null, ['id' => 'ft_label', 'placeholder' => 'Feature Name', 'class' => 'form-control']) }}
                  <span name="emsg-ft_label" class="validation-error hideme"></span>
                  {{ Form::hidden('ft_level', '1' ) }}
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Input Type &nbsp; <small><span class="fa fa-star red"></span></small> &nbsp;  
                  <small style="font-weight:normal;">
                    <a class="icon-action lblue" data-toggle="modal" data-target="#mdInputtype" title='Knowing "Input Type"'><u>help</u>
                      <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                  </small>
                </label>
                {{ Form::select('ft_type', $ft_types, 'Text-box', [ 'id' => 'ft_type', 'class' => 'form-control' ] ) }}
                <span name="emsg-ft_type" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Unique? &nbsp; <small><span class="fa fa-star red"></span></small></label><br/>
                {{ Form::radio('ft_unique', 'Yes', null, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
                {{ Form::radio('ft_unique', 'No', null, [ 'class' => 'square-red' ]) }} No
                <span name="emsg-ft_unique" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr clr-fields"></div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Validations &nbsp; 
                  <small style="font-weight:normal;">
                    <a class="icon-action lblue" data-toggle="modal" data-target="#mdValidation" title="Available Validations and how to apply them"><u>help</u>
                      <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                  </small>
                </label>
                  {{ Form::text('ft_validation', null, ['id' => 'ft_validation', 'placeholder' => 'Validations', 'class' => 'form-control']) }}
                  <span name="emsg-ft_validation" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Values &nbsp; 
                  <small style="font-weight:normal;">
                    <a class="icon-action lblue" data-toggle="modal" data-target="#mdValues" title="How to add Values"><u>help</u>
                      <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                  </small>
                </label>
                  {{ Form::text('ft_values', null, ['id' => 'ft_values', 'placeholder' => 'Values', 'class' => 'form-control']) }}
                  <span name="emsg-ft_values" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr clr-fields"></div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Data Type &nbsp; <small><span class="fa fa-star red"></span></small> &nbsp;  
                  <small style="font-weight:normal;">
                    <a class="icon-action lblue" data-toggle="modal" data-target="#mdDatatype" title='Working with "Data Type"'><u>help</u>
                      <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                  </small>
                </label>
                {{ Form::select('ft_data_type', $data_types, null, [ 'id' => 'ft_data_type', 'class' => 'form-control' ] ) }}
                <span name="emsg-ft_data_type" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label>Decimal Places</label>
                {{ Form::selectRange('ft_decs', 0, 10, null, [ 'id' => 'ft_decs', 'class' => 'form-control' ] ) }}
                <span name="emsg-ft_decs" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Value Assigned By &nbsp; <small><span class="fa fa-star red"></span></small></label>
                {{ Form::select('ft_value_assigned_by', $assigned_by, null, [ 'id' => 'ft_value_assigned_by', 'class' => 'form-control' ] ) }}
                <span name="emsg-ft_value_assigned_by" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label>Display Order </label>
                  {{ Form::text('ft_disp_order', null, ['id' => 'ft_disp_order', 'placeholder' => 'Display Order', 'class' => 'form-control']) }}
                  <span name="emsg-ft_disp_order" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label>Active? &nbsp; <small><span class="fa fa-star red"></span></small></label><br/>
                {{ Form::select('is_active', [ 'No' => 'No', 'Yes' => 'Yes' ], null, [ 'id' => 'is_active', 'class' => 'form-control' ] ) }}
                <span name="emsg-is_active" class="validation-error hideme"></span>
              </div>
            </div>

            <div class="clr clr-fields"></div>

            <div class="box-footer" style="padding: 15px 15px;">

              {{ Form::submit('  Save  ', ['id' => 'btnSave', 'name' => 'btnSave', 'class' => 'btn btn-primary']) }} &nbsp; 
              <input value=" Back " name="btnExit" class="btn bg-gray" type="button" onclick="window.location.href='{{ URL::route('masterdata.vendormodelfeature') }}'" />
               &nbsp; &nbsp; 
              <input value="Add Child" name="btnAdd" id="btnAdd" class="btn btn-success" type="button" /> &nbsp; 
              <a class="icon-action lblue" data-toggle="modal" data-target="#mdChildhelp" title='What is a "Child Feature"'><u>What is a "Child Feature"</u>
                <span class="glyphicon glyphicon-question-sign"></span>
              </a>
            </div>

          
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /search form -->
      {{ Form::close() }}
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->

  @include('includes.feature._help')

</section><!-- /.content -->

@stop