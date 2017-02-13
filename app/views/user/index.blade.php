@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> User <small></small> </h1>
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
          {{ Form::open( array('id' => 'frmSrch', 'route' => 'user.index', 'method' => 'post') ) }}

            <!-- text input -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Name</label>
                <input name="srchName" type="text" class="form-control" placeholder="Name"  value="{{show($params, 'srchName')}}"/>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Username</label>
                <input name="srchUName" type="text" class="form-control" placeholder="Username"  value="{{show($params, 'srchUName')}}"/>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Group</label>
                <input name="srchGrp" type="text" class="form-control" placeholder="Group"  value="{{show($params, 'srchGrp')}}"/>
              </div>
            </div>


            <div class="box-footer" style="padding: 10px 15px;">
              <input value="  Search  " id="btnSearch" name="btnSearch" class="btn btn-primary" type="submit" /> &nbsp; 
              <input value="  Clear  " name="btnClear" class="btn bg-gray" type="submit" />
              <input type="hidden" id="srchOBy" name="srchOBy" value="{{show($params, 'srchOBy')}}" />
              <input type="hidden" id="srchOTp" name="srchOTp" value="{{show($params, 'srchOTp')}}" />

              <input value="Add New" name="btnAdd" class="btn btn-success pull-right" type="button" onclick="window.location.href='{{ URL::route('user.create') }}'" />
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
              <th width="30%" class="orderable" data-field="tbl_user.user_name">Name</th>
              <th width="25%" class="orderable" data-field="tbl_user.username">Username</th>
              <th width="20%">Groups</th>
              <th width="15%" class="orderable" data-field="tbl_user.is_active">Active</th>
              <th width="10%">Action</th>
            </tr>

            @foreach($records as $k => $r)
            <tr>
              <td>{{ $r->user_name }}</td>
              <td>{{ $r->username }}</td>
              <td><!-- @{{ $r->user_groups }} -->
                <?php
                  if($r->groups) {
                    $ug = '';
                    $groups = $r->groups()->orderBy('group_name')->get();
                    foreach($groups as $g) $ug .= ', ' . $g->group_name;
                    echo ltrim($ug, ', ');
                  }
                ?>
              </td>
              <td>{{ $r->is_active }}</td>
              <td>
                <span class="glyphicon glyphicon-edit icon-action lblue" onclick="window.location.href='{{ URL::route('user.edit', $r->_id) }}'" title="Edit"></span> &nbsp; &nbsp; 
                <span class="glyphicon glyphicon-trash icon-action red" onclick="javascript:confirmAction('{{ URL::route('user.destroy', $r->_id) }}', 'Delete this record?')" title="Delete"></span>
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