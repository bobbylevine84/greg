@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Vendor Model <small></small> </h1>
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
          {{ Form::open( array('id' => 'frmSrch', 'route' => 'vendormodel.index', 'method' => 'post') ) }}

            <!-- text input -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Vendor Name</label>
                <input name="srchVName" type="text" class="form-control" placeholder="Vendor Name"  value="{{show($params, 'srchVName')}}"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Model Name</label>
                <input name="srchMName" type="text" class="form-control" placeholder="Model Name"  value="{{show($params, 'srchMName')}}"/>
              </div>
            </div>

            <div class="box-footer" style="padding: 10px 15px;">
              <input value="  Search  " id="btnSearch" name="btnSearch" class="btn btn-primary" type="submit" /> &nbsp; 
              <input value="  Clear  " name="btnClear" class="btn bg-gray" type="submit" />
              <input type="hidden" id="srchOBy" name="srchOBy" value="{{show($params, 'srchOBy')}}" />
              <input type="hidden" id="srchOTp" name="srchOTp" value="{{show($params, 'srchOTp')}}" />

              <input value="Add New" name="btnAdd" class="btn btn-success pull-right" type="button" onclick="window.location.href='{{ URL::route('vendormodel.create') }}'" />
            </div>

          {{ Form::close() }}
        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <!-- /search form -->

      <!-- list table -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">List</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <tr>
              <th width="35%" class="orderable" data-field="tbl_vendor.vendor_name">Vendor Name</th>
              <th width="40%" class="orderable" data-field="tbl_vendor_model.model_name">Model Name</th>
              <th width="15%" class="orderable" data-field="tbl_vendor_model.is_active">Active</th>
              <th width="10%">Action</th>
            </tr>

            @foreach($records as $k => $r)
            <tr>
              <td>{{ $r->vendor_name }}</td>
              <td>{{ $r->model_name }}</td>
              <td>{{ $r->is_active }}</td>
              <td>
                <span class="glyphicon glyphicon-edit icon-action lblue" onclick="window.location.href='{{ URL::route('vendormodel.edit', $r->_id) }}'" title="Edit"></span> &nbsp; &nbsp; 
                <span class="glyphicon glyphicon-trash icon-action red" onclick="javascript:confirmAction('{{ URL::route('vendormodel.destroy', $r->_id) }}', 'Delete this record?')" title="Delete"></span>
              </td>
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