@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Vendor Model Feature <small></small> </h1>
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
          {{ Form::open( array('id' => 'frmSrch', 'route' => 'masterdata.vendormodelfeature', 'method' => 'post') ) }}

            <!-- text input -->
            <div class="col-md-12">
              <div class="form-group">
                <label>Feature Name</label>
                <input name="srchVMFName" type="text" class="form-control" placeholder="Feature Name"  value="{{show($params, 'srchVMFName')}}"/>
              </div>
            </div>

            <div class="box-footer" style="padding: 10px 15px;">
              <input value="  Search  " id="btnSearch" name="btnSearch" class="btn btn-primary" type="submit" /> &nbsp; 
              <input value="  Clear  " name="btnClear" class="btn bg-gray" type="submit" />
              <input type="hidden" id="srchOBy" name="srchOBy" value="{{show($params, 'srchOBy')}}" />
              <input type="hidden" id="srchOTp" name="srchOTp" value="{{show($params, 'srchOTp')}}" />

              <input value="Add New" name="btnAdd" class="btn btn-success pull-right" type="button" onclick="window.location.href='{{ URL::route('masterdata.createvendormodelfeature') }}'" />
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
              <th width="60%" class="orderable" data-field="ft_label">Feature Name</th>
              <th width="15%" class="orderable" data-field="ft_type">Type</th>
              <th width="15%" class="orderable" data-field="is_active">Active</th>
              <th width="10%">Action</th>
            </tr>

            @foreach($records as $k => $r)
            <tr>
              <td>{{ $r->ft_label }}</td>
              <td>{{ $r->ft_type }}</td>
              <td>{{ $r->is_active }}</td>
              <td>
                <span class="glyphicon glyphicon-edit icon-action lblue" onclick="window.location.href='{{ URL::route('masterdata.editvendormodelfeature', $r->_id) }}'" title="Edit"></span> &nbsp; &nbsp; 
                <span class="glyphicon glyphicon-trash icon-action red" onclick="javascript:confirmAction('{{ URL::route('masterdata.destroyvendormodelfeature', $r->_id) }}', 'Delete this record?')" title="Delete"></span>
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