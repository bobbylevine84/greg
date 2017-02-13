@extends('layouts.app')

@section('content')

<style>

/*
  .v-mid {
    float:none;
    display:inline-block;
    vertical-align:middle;
  }
*/

  .txtbl { color:#000000; }

  #dash-logo {
    max-width: 30%;
    padding-top: 15%;
  }

  #img-customer {
    max-width: 30%;
  }

  #img-partner {
    max-width: 50%;
    padding: 28.5% 0;
  }

  @media (max-width: 991px) {
    #img-partner {
      padding: 20% 0 2% 0;
    }
  }

  #ln-customer {

  }

  #ln-partner {
    
  }

</style>

<!-- Content Header (Page header) -->
<!-- <section class="content-header">
  <h1> &nbsp; <small></small> </h1>
</section> -->

<!-- Main content -->
<section class="content">

  @include('includes.app.formalerts')

  <div class="row">

    <center>
      <div class="col-md-12">
        <img id="dash-logo" src="{{ asset('public/dist/img/custom/logo.png') }}"/>
        <!-- <h3 class="txtbl">Inside Sales Portal</h3> -->
      </div>

      <h4 class="">&nbsp;</h4>

      <div class="col-md-12">
        <h1>{{ $myApp->sp_title }}</h1>
      </div>

    </center>


    <h4 class="">&nbsp;</h4>


  </div><!-- /.row -->


</section><!-- /.content -->

@stop