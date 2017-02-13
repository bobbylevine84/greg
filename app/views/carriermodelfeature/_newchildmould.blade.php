<div class="col-md-12"><h4>Child {{ $ck + 1 }}</h4></div>
<br/>
<br/>

<div class="col-md-6">
  <div class="form-group">
    <label>Feature Name &nbsp; <small><span class="fa fa-star red"></span></small></label>
      {{ Form::text('child[' . $ck . '][ft_label]', null, ['id' => 'ft_label_'.$ck, 'placeholder' => 'Feature Name', 'class' => 'form-control']) }}
      <span name="emsg-child[{{ $ck }}][ft_label]" class="validation-error hideme"></span>
      {{ Form::hidden('keys['.$ck.']', '0' ) }}
      {{ Form::hidden('child[' . $ck . '][ft_level]', '2' ) }}
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
    {{ Form::select('child[' . $ck . '][ft_type]', $ft_types, 'Text-box', [ 'id' => 'ft_type_'.$ck, 'class' => 'form-control' ] ) }}
    <span name="emsg-child[{{ $ck }}][ft_type]" class="validation-error hideme"></span>
  </div>
</div>

<div class="col-md-3">
  <div class="form-group">
    <label>Unique? &nbsp; <small><span class="fa fa-star red"></span></small></label><br/>
    {{ Form::radio('child['. $ck . '][ft_unique]', 'Yes', true, [ 'class' => 'square-red' ]) }} Yes &nbsp;  &nbsp; 
    {{ Form::radio('child['. $ck . '][ft_unique]', 'No', null, [ 'class' => 'square-red' ]) }} No
    <span name="emsg-child[{{ $ck }}][ft_unique]" class="validation-error hideme"></span>
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
      {{ Form::text('child[' . $ck . '][ft_validation]', null, ['id' => 'ft_validation_'.$ck, 'placeholder' => 'Validations', 'class' => 'form-control']) }}
      <span name="emsg-child[{{ $ck }}][ft_validation]" class="validation-error hideme"></span>
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
      {{ Form::text('child['. $ck . '][ft_values]', null, ['id' => 'ft_values_'.$ck, 'placeholder' => 'Values', 'class' => 'form-control']) }}
      <span name="emsg-child[{{ $ck }}][ft_values]" class="validation-error hideme"></span>
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
    {{ Form::select('child['. $ck . '][ft_data_type]', $data_types, 'Text', [ 'id' => 'ft_data_type_'.$ck, 'class' => 'form-control' ] ) }}
    <span name="emsg-child[{{ $ck }}][ft_data_type]" class="validation-error hideme"></span>
  </div>
</div>

<div class="col-md-2">
  <div class="form-group">
    <label>Decimal Places</label>
    {{ Form::selectRange('child['. $ck . '][ft_decs]', 0, 10, null, [ 'id' => 'ft_decs_'.$ck, 'class' => 'form-control' ] ) }}
    <span name="emsg-child[{{ $ck }}][ft_decs]" class="validation-error hideme"></span>
  </div>
</div>

<div class="col-md-3">
  <div class="form-group">
    <label>Value Assigned By &nbsp; <small><span class="fa fa-star red"></span></small></label>
    {{ Form::select('child['. $ck . '][ft_value_assigned_by]', $assigned_by, null, [ 'id' => 'ft_value_assigned_by_'.$ck, 'class' => 'form-control' ] ) }}
    <span name="emsg-child[{{ $ck }}][ft_value_assigned_by]" class="validation-error hideme"></span>
  </div>
</div>

<div class="col-md-2">
  <div class="form-group">
    <label>Child Order </label>
      {{ Form::text('child['. $ck . '][ft_disp_order]', $ck + 1, ['id' => 'ft_disp_order_'.$ck, 'placeholder' => 'Child Order', 'class' => 'form-control']) }}
      <span name="emsg-child[{{ $ck }}][ft_disp_order]" class="validation-error hideme"></span>
  </div>
</div>

<div class="col-md-2">
  <div class="form-group">
    <label>Active? &nbsp; <small><span class="fa fa-star red"></span></small></label><br/>
    {{ Form::select('child['. $ck . '][is_active]', [ 'Yes' => 'Yes', 'No' => 'No' ], null, [ 'id' => 'is_active_'.$ck, 'class' => 'form-control' ] ) }}
    <span name="emsg-child[{{ $ck }}][is_active]" class="validation-error hideme"></span>
  </div>
</div>

<div class="clr clr-fields"></div>
