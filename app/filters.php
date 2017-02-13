<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//

	// $myApp Singleton object
	App::singleton('myApp', function(){
		$app = new stdClass;
		$app->title = "E2E";

		//Auth::account()->check()
		if(Auth::admin()->check()) {
			$app->user 		  = Auth::admin()->get();
			$app->uid 		  = $app->user->_id;
			$app->pid 		  = 0;
			$app->uname 	  = $app->user->name;
			$app->utype 	  = $app->user->user_type;
			$app->isSU 		  = ($app->user->is_su == 1);
			$app->isCustAdmin = FALSE;
			$app->custAdminID = 0;
			$app->RUK 		  = $app->user->ruk;
			$app->isUser 	  = FALSE;
			$app->isLogedin   = TRUE;
		}
		else if (Auth::customer()->check()) {
			$app->user 		  = Auth::customer()->get();
			$app->uid 		  = $app->user->_id;
			$app->pid 		  = $app->uid;
			$app->uname 	  = $app->user->comp_name;
			$app->utype 	  = $app->user->user_type;
			$app->isSU 		  = FALSE;
			$app->isCustAdmin = TRUE;
			$app->custAdminID = $app->uid;
			$app->RUK 		  = $app->user->ruk;
			$app->isUser 	  = FALSE;
			$app->isLogedin   = TRUE;
		}
		else if (Auth::user()->check()) {
			$app->user 		  = Auth::user()->get();
			$app->uid 		  = $app->user->_id;
			$app->pid 		  = $app->user->parent->_id;
			$app->uname 	  = $app->user->user_name;
			$app->utype 	  = $app->user->user_type;
			$app->isSU 		  = FALSE;
			$app->isCustAdmin = $app->user->isAdmin();
			$app->custAdminID = $app->user->adminID();
			$app->RUK 		  = $app->user->parent->ruk;
			$app->isUser 	  = TRUE;
			$app->isLogedin   = TRUE;
		}
		else {
			$app->user 		  = FALSE;
			$app->uid 		  = FALSE;
			$app->uname 	  = FALSE;
			$app->utype 	  = FALSE;
			$app->isSU 		  = FALSE;
			$app->isCustAdmin = FALSE;
			$app->custAdminID = 0;
			$app->RUK 		  = FALSE;
			$app->isUser 	  = FALSE;
			$app->isLogedin   = FALSE;
		}

// echo '<pre>';
// print_r($app->user);
// echo '</pre>';
// //exit(0);

		//$app->sp_title = $app->utype == 'VARACC' ? 'E2E VAR Portal' : 'VAR Portal Administration';
		$app->sp_title = 'E2E Provisioner';

		// define certain admin settings globally
		$sets = AppSetting::all();
		if($sets) {
			foreach($sets as $set) {
				if (!defined($set->key)) define($set->set_key, $set->set_value);
			}
		}

		return $app;
	});
	$app = App::make('myApp');
	View::share('myApp', $app);

});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	//if (Auth::guest())
	if(Auth::admin()->guest() && Auth::customer()->guest() && Auth::user()->guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic('username');
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
