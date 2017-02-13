<h4 >Vendor Details </h4>

<div class="col-md-6">
  <div class="form-group">
    <label>Vendor Name</label>
      <span class="form-control" readonly>{{ $record->vendor->vendor_name }}</span>
      {{ Form::hidden('vendor_id', $record->vendor->_id ) }}
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label>Vendor Model Name</label>
      <span class="form-control" readonly>{{ $record->vendormodel->model_name }}</span>
      {{ Form::hidden('vendor_model_id', $record->vendormodel->_id ) }}
  </div>
</div>

<div class="clr"></div>

<div class="col-md-6">
  <div class="form-group">
    <label>Radio Inventory</label>
      <span class="form-control" readonly>{{ $radioinv }}</span>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label>Serial Number Required?</label>
      <span class="form-control" readonly>{{ $record->need_vendor_sku }}</span>
  </div>
</div>

<div class="clr"></div>

@if($record->carrier)

  <h4 >Carrier Details </h4>

  <div class="col-md-6">
    <div class="form-group">
      <label>Carrier Name</label>
        <span class="form-control" readonly>{{ $record->carrier->carrier_name }}</span>
        {{ Form::hidden('carrier_id', $record->carrier->_id ) }}
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Carrier Model Name</label>
        <span class="form-control" readonly>{{ $record->carriermodel->model_name }}</span>
        {{ Form::hidden('carrier_model_id', $record->carriermodel->_id ) }}
    </div>
  </div>

  <div class="clr"></div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Carrier Inventory</label>
        <span class="form-control" readonly>{{ $carrierinv }}</span>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Serial Number Required?</label>
        <span class="form-control" readonly>{{ $record->need_carrier_sku }}</span>
    </div>
  </div>

  <div class="clr"></div>
@else
  {{ Form::hidden('carrier_id', '0' ) }}
  {{ Form::hidden('carrier_model_id', '0' ) }}
@endif

<div class="col-md-6">
  <div class="form-group">
    <label>Number of Deployments &nbsp; <small><span class="fa fa-star red"></span></small></label>
    @if($needvendorsno || $needcarriersno)
      {{ Form::selectRange('no_of_deploy', 0, $allowed_deployments, null, [ 'id' => 'no_of_deploy', 'class' => 'form-control' ]) }}
    @else
      {{ Form::text('no_of_deploy', 0, ['id' => 'no_of_deploy', 'placeholder' => 'Number of Deployments', 'class' => 'form-control']) }}
    @endif
      <span name="emsg-no_of_deploy" class="validation-error hideme"></span>
      {{ Form::hidden('cards_per_radio', $cards_per_radio ) }}
      {{ Form::hidden('customer_id', $customer_id ) }}
  </div>
</div>
