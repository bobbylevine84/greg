@extends('layouts.app')

@section('headscripts')
<style type="text/css">
  ul.pagination {margin: 0px;}
</style>
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> App Settings <small></small> </h1>
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
          {{ Form::open( array('id' => 'frmSrch', 'url' => 'appsetting/index', 'method' => 'post') ) }}
            <!-- text input -->
            <div class="col-md-4">
              <div class="form-group">
                <label>Setting Name/Value</label>
                <input name="srchText" type="text" class="form-control" placeholder="Setting Name/Value" value="{{show($params, 'srchText')}}"/>
              </div>
            </div>
            <div class="clr"></div>
            <div class="box-footer" style="padding: 10px 15px;">
              <input value="  Search  " name="btnSearch" class="btn btn-primary" type="submit" /> &nbsp; 
              <input value="  Clear  " name="btnClear" class="btn" type="submit" />
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
          {{ Form::open( array('id' => 'frmSrch', 'url' => 'appsetting/update/'.$pgn, 'method' => 'post') ) }}
            <table class="table table-bordered table-striped">
              <tr>
                <th>Description</th>
                <th width="25%">Value</th>
              </tr>

              @foreach($records as $k => $r)
              <tr>
                <td>{{ $r->set_name }}</td>
                <td>
                  {{ Form::hidden('set_key['.$k.']', $r->set_key) }}
                  {{ Form::text('set_value['.$k.']', $r->set_value, ['id' => 'set_value_'.$k, 'placeholder' => 'Value', 'class' => 'form-control validate[required]']) }}
                  {{ $errors->first('set_value['.$k.']', '<span class="validation-error">:message</span>') }}
                </td>
              </tr>
              @endforeach

            </table>

            <div class="box-footer clearfix">
              <input value=" Save " name="btnSave" class="btn btn-primary" type="submit" /> <!-- <span onclick="showActivity('saving..')" >check</span> -->
              <div class="pagination pagination-sm no-margin pull-right">
                {{ $records->links() }}
              </div>
            </div>


            

          {{ Form::close() }}
        </div><!-- /.box-body -->
      </div><!-- /.box / list table -->
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop