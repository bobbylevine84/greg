@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Staging <small></small> </h1>
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
          {{ Form::open( array('id' => 'frmSrch', 'route' => 'provision.index', 'method' => 'post') ) }}

            <!-- text input -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Template Name</label>
                <input name="srchTName" type="text" class="form-control" placeholder="Template Name"  value="{{show($params, 'srchTName')}}"/>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Vendor Name</label>
                <input name="srchVName" type="text" class="form-control" placeholder="Vendor Name"  value="{{show($params, 'srchVName')}}"/>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Vendor Model Name</label>
                <input name="srchMName" type="text" class="form-control" placeholder="Vendor Model Name"  value="{{show($params, 'srchMName')}}"/>
              </div>
            </div>

            <div class="clr"></div>

            <div class="box-footer" style="padding: 10px 15px;">
              <input value="  Search  " id="btnSearch" name="btnSearch" class="btn btn-primary" type="submit" /> &nbsp; 
              <input value="  Clear  " name="btnClear" class="btn bg-gray" type="submit" />
              <input type="hidden" id="srchOBy" name="srchOBy" value="{{show($params, 'srchOBy')}}" />
              <input type="hidden" id="srchOTp" name="srchOTp" value="{{show($params, 'srchOTp')}}" />

              @if($myApp->isCustAdmin)
                <input value="Add New" name="btnAdd" class="btn btn-success pull-right" type="button" onclick="window.location.href='{{ URL::route('provision.create') }}'" />
              @endif
            </div>

          {{ Form::close() }}
        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <!-- /search form -->

      <!-- list table -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">List</h3> <i>(Instances highlighted in pink have been released back to inventory.)</i>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <tr>
              <th width="20%" class="orderable" data-field="tbl_template.tmpl_name">Template</th>
              <th width="25%" class="orderable" data-field="tbl_vendor.vendor_name">Vendor</th>
              <th width="20%" class="orderable" data-field="tbl_vendor_model.model_name">Model</th>
              <th width="15%" class="orderable" data-field="tbl_provision.no_of_deploy">Deployments</th>
              <th width="10%" class="orderable" data-field="tbl_provision.is_active">Active</th>
              @if($myApp->isCustAdmin)
                <th width="10%">Action</th>
              @endif
            </tr>

            @foreach($records as $k => $r)
            <tr class="{{ $r->status=='Released' ? 'prov-released' : '' }}">
              <td>{{ $r->tmpl_name }}</td>
              <td>{{ $r->vendor_name }}</td>
              <td>{{ $r->model_name }}</td>
              <td>{{ $r->no_of_deploy }}</td>
              <td>{{ $r->is_active }}</td>
              @if($myApp->isCustAdmin)
                <td>
                  @if($r->status=='Staged')
                    <span class="glyphicon glyphicon-ban-circle icon-action red" onclick="javascript:confirmAction('{{ URL::route('provision.release', $r->_id) }}', '                  Release Inventory?\n(Only \'Staged\' inventory will be released.)')" title="Release"></span> &nbsp; &nbsp; 
                  @endif
                  <span class="glyphicon glyphicon-folder-open icon-action red" onclick="javascript:confirmAction('{{ URL::route('provision.archive', $r->_id) }}', 'Archive this record?')" title="Move to Archive"></span>

                  <!-- <span class="glyphicon glyphicon-edit icon-action lblue" onclick="window.location.href='@{{ URL::route('provision.edit', $r->_id) }}'" title="Edit"></span> &nbsp; &nbsp;  -->
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