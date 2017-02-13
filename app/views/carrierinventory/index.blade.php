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
          {{ Form::open( array('id' => 'frmSrch', 'route' => 'carrierinventory.index', 'method' => 'post') ) }}

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

              @if($myApp->isCustAdmin)
                <input value="Add New" name="btnAdd" class="btn btn-success pull-right" type="button" onclick="window.location.href='{{ URL::route('carrierinventory.create') }}'" />
                <input style="margin-right:5px;" value="Import Inventory" name="btnImport" class="btn btn-primary pull-right" type="button" onclick="window.location.href='{{ URL::route('carrierinventory.importfromfile') }}'" />
              @endif
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
              <th width="25%" class="orderable" data-field="carrier_name">Carrier Name</th>
              <th width="25%" class="orderable" data-field="model_name">Model Name</th>
              <th width="25%" class="orderable" data-field="sku">Serial No</th>
              <th width="15%" class="orderable" data-field="status">Status</th>
              @if($myApp->isCustAdmin)
                <th width="10%">Action</th>
              @endif
            </tr>

            @foreach($records as $k => $r)
            <tr>
              <td>{{ $r->carrier_name }}</td>
              <td>{{ $r->model_name }}</td>
              <td>{{ $r->sku }}</td>
              <td>{{ $r->status }}</td>
              @if($myApp->isCustAdmin)
                <td>
                  <span class="glyphicon glyphicon-edit icon-action lblue" onclick="window.location.href='{{ URL::route('carrierinventory.edit', $r->_id) }}'" title="Edit"></span> &nbsp; &nbsp; 
                  <span class="glyphicon glyphicon-trash icon-action red" onclick="javascript:confirmAction('{{ URL::route('carrierinventory.destroy', $r->_id) }}', 'Delete this record?')" title="Delete"></span>
                </td>
              @endif
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