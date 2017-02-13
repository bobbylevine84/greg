@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Error Page <small></small> </h1>
</section>

<!-- Main content -->
<section class="content">

	<div class="error-page">
		<h2 class="headline text-red">@if($errors->has('errorcode')) {{ $errors->first('errorcode') }} @endif</h2>
		<div class="error-content">
		  <h3><i class="fa fa-warning text-red"></i> @if($errors->has('errormsg')) {{ $errors->first('errormsg') }} @endif</h3>
		  <p>
		    @if($errors->has('suggestion')) {{ $errors->first('suggestion') }} @endif<br />
		    You may contact the System Administrator<br /> or <a href="{{ URL::to('/') }}">return to home page</a>.
		  </p>
		  <!-- <form class="search-form">
		    <div class="input-group">
		      <input name="search" class="form-control" placeholder="Search" type="text">
		      <div class="input-group-btn">
		        <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
		      </div>
		    </div>
		  </form> -->
		</div>
	</div>
</div>
@stop