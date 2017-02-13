@extends('layouts.app')

@section('headscripts')
<style type="text/css">
  ul.pagination {margin: 0px;}
</style>
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Carrier Feature <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">
    <div class="col-md-12">

      <div class="row">


        <div class="col-md-6">

          <!-- search form -->
          <!-- general form elements disabled -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              {{ Form::open( array('id' => 'frmSrch', 'route' => 'masterdata.carrierfeature', 'method' => 'post') ) }}
                <!-- text input -->

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Feature Name</label>
                    <input name="srchFName" type="text" class="form-control" placeholder="Feature Name"  value="{{show($params, 'srchFName')}}"/>
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

        </div>


        <div class="col-md-6">

          <!-- add product id form -->
          <!-- general form elements disabled -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Add Feature</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              {{ Form::open( array('id' => 'frmAdd', 'route' => ['masterdata.storecarrierfeature', $page], 'method' => 'post') ) }}
                <!-- text input -->

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Feature Name</label>
                    {{ Form::text('name', null, ['id' => 'name', 'placeholder' => 'Feature Name', 'class' => 'form-control']) }}
                    {{ $errors->first('name', '<span class="validation-error">:message</span>') }}
                  </div>
                </div>

                <div class="clr"></div>
                <div class="box-footer" style="padding: 10px 15px;">
                  <input value="  Save  " name="btnSave" class="btn btn-primary" type="submit" /> &nbsp; 
                  <input value="  Cancel  " name="btnCancel" class="btn" type="reset" />
                </div>

              {{ Form::close() }}
            </div><!-- /.box-body -->
          </div><!-- /.box -->
          <!-- /add product id form -->

        </div>

      </div>


      <!-- list table -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">List</h3>
        </div><!-- /.box-header -->

        @include('carrierfeature._edit')

      </div><!-- /.box / list table -->
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop