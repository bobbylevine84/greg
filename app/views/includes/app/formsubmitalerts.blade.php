@foreach (['error', 'warning', 'done', 'info'] as $type => $cls)
  @if($type == 'error' && Session::has('flash-error'))
	<div class="alert alert-danger alert-dismissable autoclose">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4><i class="icon fa fa-ban"></i> Error!</h4>
		{{ Session::get('flash-error') }}
	</div>
  @endif
  @if($type == 'warning' && Session::has('flash-warning'))
	<div class="alert alert-warning alert-dismissable autoclose">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4><i class="icon fa fa-warning"></i> Warning!</h4>
		{{ Session::get('flash-warning') }}
	</div>
  @endif
  @if($type == 'done' && Session::has('flash-done'))
	<div class="alert alert-success alert-dismissable autoclose">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4><i class="icon fa fa-check"></i> Success!</h4>
		{{ Session::get('flash-done') }}
	</div>
  @endif
  @if($type == 'info' && Session::has('flash-info'))
	<div class="alert alert-info alert-dismissable autoclose">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4><i class="icon fa fa-info"></i> Info!</h4>
		{{ Session::get('flash-info') }}
	</div>
  @endif
@endforeach