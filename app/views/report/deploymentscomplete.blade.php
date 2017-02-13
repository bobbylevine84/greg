@extends('layouts.app')

@section('lscripts')

  <!--for local scripts-->
  $(document).ready(function() {

/*
    $('[rel="ddmodal"]').click(function() {
      $('#ddifrm').attr('src', '');
      var isrc = $(this).data('src-url');

      $('#mdDepDet').on('shown.bs.modal', function() {
          //$(this).find('iframe').attr('src', isrc);
          $('#ddifrm').attr('src', isrc);
      })  
      $('#mdDepDet').modal('show');
    });
*/

    $('[rel="ddmodal"]').click(function() {

      $('#ddlist').html('');

      var url = $(this).data('src-url');

      $('#mdDepDet').on('shown.bs.modal', function() {
        $.get(url, function(data) {
          $('#ddlist').html(data);
        });
      })  
      $('#mdDepDet').modal('show');
    });

// ddlist

  });

@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Deployments Completed <small></small> </h1>
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
          {{ Form::open( array('id' => 'frmSrch', 'route' => 'report.deploymentscompleted', 'method' => 'post') ) }}

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
              <th width="15%" class="" data-field="tbl_provision.no_of_deploy">Staged</th>
              <th width="10%" class="" data-field="tbl_provision.is_active">Provisioned</th>
            </tr>

            @foreach($records as $k => $r)
              <?php
                $prov = Provision::find($r->_id);
                $dpcount = $prov->deployeditems()->count();
              ?>
              <tr class="{{ $r->status=='Released' ? 'prov-released' : '' }}">
                <td>{{ $r->tmpl_name }}</td>
                <td>{{ $r->vendor_name }}</td>
                <td>{{ $r->model_name }}</td>
                <td>{{ $prov->stageditems()->count() }}</td>
                <td>

                  <!-- <a href="#" class="btn" id="openBtn" rel="ddmodal">Open modal</a> -->
                  @if($dpcount<=0)
                    0
                  @else
                    <span class="icon-action lblue" rel="ddmodal" 
                      data-src-url="{{ URL::route('report.deploymentdetails', [ $r->_id ]) }}" 
                      data-title="Deployment Details">

                      <b><u>{{ $dpcount }}</u></b>
                    </span>
                  @endif

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

  <div class="">


    <!-- Child Help Modal -->
    <div class="modal fade" id="mdDepDet" tabindex="-1" role="dialog" aria-labelledby="mdDepDetLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="mdDepDetLabel">Deployment Details</h4>
          </div>
          <div class="modal-body">

            <!-- modal body content -->

            <div id="ddlist" style="min-height:100px;">

            </div>

            <!-- <iframe id="ddifrm" src="" class="mypopover-content" frameborder="0" allowtransparency="true" scrolling="no" seamless ></iframe> -->

            <!-- <p>
              A "Child Feature" might be required if you wish to create a Group of fields. 
              In such cases, typically one would create a field with Input Type "Label" and add childs to it. 
              A "Child" field would always have its parent as the first field of the form.
            </p>

            <h4>When should I create a "Child" field</h4>

            <p>
              As a rule of thumb, if you want multiple fields in Provisioning you need to create childs, 
              but if a single field is needed then one should not create a "Child" field. 
              Each field in a form would create a corresponding field while Provisioning. 
              So, creating unwanted "Child" fields would create unwanted Provisioning field and can have unexpected results.
            </p>

            <p>
              All input, validation and other rules and principles are applicable for "Child" fields too.
            </p>

            <p>
              <b>IMPORTANT: A new "Child Feature" or any changes to an existing "Child Feature" is ignored if the "Feature Name" 
                field for the particular "Child" entry is blank and data is not saved to the database.</b>
            </p> -->

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <div id="ddModal" class="modal hide fade" tabindex="-1" role="dialog">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
          <h3>Dialog</h3>
      </div>
      <div class="modal-body">
          <!-- <iframe src="" style="zoom:0.60" width="99.6%" height="250" frameborder="0"></iframe> -->
          Hello there, I am modal content :)
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal">OK</button>
      </div>
    </div>

  </div>


</section><!-- /.content -->

@stop