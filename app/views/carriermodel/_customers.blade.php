<div class="form-group">

  <br />
  @foreach($customers as $id => $nm)
    <?php $chk = is_array($selcustomers) && in_array($id, $selcustomers) ? true : false; ?>

    <div class="col-md-3">
      <div class="form-group">
        {{ Form::checkbox('cust_ids[]', $id, $chk, [ 'class' => 'square-red' ]) }} {{ $nm }}
      </div>
    </div>

  @endforeach

</div>