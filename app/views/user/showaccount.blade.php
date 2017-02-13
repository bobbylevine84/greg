@extends('layouts.app')

@section('lscripts')
<!--for local scripts-->
  $(document).ready(function() {
    $("#frmRecord1").validationEngine({
      promptPosition: "topLeft",
      onValidationComplete: function(frm, res) {
        return res;
      }
    });

    // styled checkboxes
    //Red color scheme for iCheck
    $('input[type="checkbox"].square-red').iCheck({
      checkboxClass: 'icheckbox_square-red'
    });

  });
@stop

@section('hassets')
  <!-- For iCheckbox -->
  {{ HTML::style('public/plugins/iCheck/all.css', array('type' => 'text/css', 'rel' => 'stylesheet' )) }}
@stop

@section('footscripts')
  <!-- iCheck 1.0.1 -->
  {{ HTML::script('public/plugins/iCheck/icheck.min.js', array('type' => 'text/javascript')) }}
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> VAR Account <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">
    <div class="col-md-12">

      {{ Form::model( $record, array('id' => 'frmRecord', 'route' => ['varacc.updatemyaccount', $record->var_id], 'method' => 'post', 'autocomplete' => 'off') ) }}

        <!-- search form -->
        <!-- general form elements disabled -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">View Account</h3>
          </div><!-- /.box-header -->
          <div class="box-body">

            <!-- text input -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Username</label>
                <span class="form-control" disabled>{{ $record->username }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Customer Number</label>
                <span class="form-control" disabled>{{ $record->cust_no }}</span>
              </div>
            </div>

            <div class="clr"></div>


        </div><!-- /.box-body -->
        <!-- / Billing -->

        <!-- Account Details -->
        <div class="box-header with-border">
          <h3 class="box-title">Account Details</h3>
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="col-md-6">
              <div class="form-group">
                <label>Company Name</label>
                <span class="form-control" disabled>{{ $record->onboarding->comp_name }}</span>
              </div>
            </div>

            <div class="clr"></div>

            <div class="col-md-6">
              <div class="form-group">
                <label>First Name</label>
                <span class="form-control" disabled>{{ $record->onboarding->first_name }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Last Name</label>
                <span class="form-control" disabled>{{ $record->onboarding->last_name }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Contact Email</label>
                <span class="form-control" disabled>{{ $record->onboarding->con_email }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Contact Phone</label>
                <span class="form-control" disabled>{{ $record->onboarding->con_phone }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>E2E Products Discount Level Percent</label>
                <span class="form-control" disabled>{{ $record->onboarding->prod_disc }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Radio Discount Level Percent</label>
                <span class="form-control" disabled>{{ $record->onboarding->radio_disc }}</span>
              </div>
            </div>

<!-- 
            <div class="col-md-6">
              <div class="form-group">
                <label>Accessories Discount Level Percent</label>
                <span class="form-control" disabled>{{ $record->onboarding->accs_disc }}</span>
              </div>
            </div>
 -->

            <div class="col-md-6">
              <div class="form-group">
                <label>XetaWave Radio Discount Level Percent</label>
                <span class="form-control" disabled>{{ $record->onboarding->xetawave_disc }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Payment Terms <small>(days)</small></label>
                <span class="form-control" disabled>{{ $record->onboarding->pay_term }}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Territory</label>
                <span class="form-control" disabled>{{ $record->territory }}</span>
              </div>
            </div>


            <div class="clr"></div>


        </div><!-- /.box-body -->
        <!-- / Billing -->

        <!-- Account Details -->
        <div class="box-header with-border">
          <h3 class="box-title">Industries Served</h3>
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="col-md-12">
              <div class="form-group">
                <label>Industries Served </label> <br />
                <!-- <span class="form-control">&nbsp;</span> -->

                @if($record->industries && count($record->industries)>0)
                  @foreach($record->industries as $ind)

                    <div class="col-md-3">
                      <div class="form-group">
                        <!-- <span class="form-control" disabled>{{ $ind->inds_name }}</span> -->
                        <input type="checkbox" class="square-red" checked disabled> &nbsp; {{ $ind->inds_name }}
                      </div>
                    </div>

                  @endforeach
                @else
                  <span class="form-control" disabled>No Industries Served.</span>
                @endif

              </div>
            </div>

            <div class="clr"></div>

        </div><!-- /.box-body -->


        <!-- Contact -->
        <div class="box-header with-border">
          <h3 class="box-title">E2E Customer Service, Orders, and Account Receivables</h3>
        </div><!-- /.box-header -->

        <div class="box-body">

          <div class="col-md-6">
            <div class="form-group">
              <h4>End 2 End Technologies HQ</h4>
              <h4>60 Sycamore Street West</h4>
              <h4>St. Paul, MN  55117</h4>
              <h4><a href="http://www.e2etechinc.com" target="_blank">http://www.e2etechinc.com</a></h4>
              <h4>Phone: 651-560-0321</h4>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <h4 class="hidden-md hidden-lg">&nbsp;</h4>
              <h4>End 2 End Technologies Warehouse</h4>
              <h4>1017 South Kansas Avenue</h4>
              <h4>Liberal, Kansas 67901</h4>
              <h4><a href="mailto:orders@e2etechinc.com" target="_blank">orders@e2etechinc.com</a></h4>
            </div>
          </div>

<!--           <div class="col-md-6">
            <div class="form-group">
              <label>End 2 End Technologies HQ</label><br />
              <label>60 Sycamore Street West</label><br />
              <label>St. Paul, MN  55117</label><br />
              <label><a href="http://www.e2etechinc.com" target="_blank">http://www.e2etechinc.com</a></label><br />
              <label>Phone: 651-560-0321</label>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>End 2 End Technologies Warehouse</label><br />
              <label>1017 South Kansas Avenue</label><br />
              <label>Liberal, Kansas 67901</label><br />
              <label><a href="mailto:orders@e2etechinc.com" target="_blank">orders@e2etechinc.com</a></label>
            </div>
          </div>
 -->
          <div class="clr"></div>

        </div><!-- /.box-body -->
        <!-- / Contact -->


        <div class="box-body">

            <div class="box-footer" style="padding: 10px 15px;">
               <input value=" Back " name="btnExit" class="btn bg-gray" type="button" onclick="window.location.href='{{ URL::route('varacc.index') }}'" />
            </div>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <!-- /search form -->

      {{ Form::close() }}

    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->


</section><!-- /.content -->

@stop