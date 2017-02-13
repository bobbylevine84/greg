@extends('layouts.app')
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

      <!-- search form -->
      <!-- general form elements disabled -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Search</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {{ Form::open( array('id' => 'frmSrch', 'route' => 'report.carrierinventory', 'method' => 'post') ) }}

            <!-- text input -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Carrier</label>
                <select name="srchCICarrier" class="form-control">
                  <option value="">Select Carrier</option>
                  @foreach($carriers as $id => $nm)
                    <option value="{{ $id }}" <?php if(show($params, 'srchCICarrier')==$id) echo 'selected'; ?>>{{ $nm }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Model</label>
                <select name="srchCIModel" class="form-control">
                  <option value="">Select Model</option>
                  @foreach($models as $id => $nm)
                    <option value="{{ $id }}" <?php if(show($params, 'srchCIModel')==$id) echo 'selected'; ?>>{{ $nm }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Status</label>
                <select name="srchCIStatus" class="form-control">
                  <option value="">Select Status</option>
                  @foreach($statuses as $id => $nm)
                    <option value="{{ $id }}" <?php if(show($params, 'srchCIStatus')==$id) echo 'selected'; ?>>{{ $nm }}</option>
                  @endforeach
                </select>
              </div>
            </div>


            <div class="clr"></div>

            <div class="box-footer" style="padding: 10px 15px;">
              <input value="  Search  " id="btnSearch" name="btnSearch" class="btn btn-primary" type="submit" /> &nbsp; 
              <input value="  Clear  " name="btnClear" class="btn bg-gray" type="submit" />
              <input type="hidden" id="srchOBy" name="srchOBy" value="{{show($params, 'srchOBy')}}" />
              <input type="hidden" id="srchOTp" name="srchOTp" value="{{show($params, 'srchOTp')}}" />

            </div>

          {{ Form::close() }}
        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <!-- /search form -->

      <!-- list table -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">List</h3> <span class="e2e">({{ $records->getFrom() }} to {{ $records->getTo() }} of {{ $records->getTotal() }})</span>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <tr>
              <th width="30%" class="orderable" data-field="tbl_carrier.carrier_name">Carrier Name</th>
              <th width="30%" class="orderable" data-field="tbl_carrier_model.model_name">Model Name</th>
              <th width="25%" class="orderable" data-field="tbl_carrier_inventory.sku">Serial No</th>
              <th width="15%" class="orderable" data-field="tbl_carrier_inventory.status">Status</th>
            </tr>

            @foreach($records as $k => $r)
            <tr>
              <td>{{ $r->carrier_name }}</td>
              <td>{{ $r->model_name }}</td>
              <td>{{ $r->sku }}</td>
              <td>{{ $r->status }}</td>
            </tr>
            @endforeach

          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <div class="pagination pagination-sm no-margin pull-right">
            {{ $records->links() }}
          </div>
        </div>
      </div><!-- /.box / list table -->
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop