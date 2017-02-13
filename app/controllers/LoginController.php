<?php

class LoginController extends BaseController {

	function __construct() {
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function login()	{

		//if(Auth::check()) return Redirect::to('/');
		if(Auth::admin()->check() || Auth::customer()->check() || Auth::user()->check()) return Redirect::to('/');

		$username = Input::get('username');
        $password = Input::get('password');
        $ruk 	  = Input::get('ruk');

	    // create the validation rules ------------------------
	    $rules = array(
	        'username' => 'required',                        // just a normal required validation
	        'password' => 'required',
	    );

	    // do the validation ----------------------------------
	    // validate against the inputs from our form
	    $validator = Validator::make(Input::all(), $rules);

	    // check if the validator failed -----------------------
	    if ($validator->fails()) {

	        // get the error messages from the validator
	        //$messages = $validator->messages();

	        // redirect our user back to the form with the errors from the validator
	        //return Redirect::to('ducks')
	        //    ->withErrors($validator);

	        return Redirect::back()
	            ->withInput()
	            ->withErrors($validator);

	    } else {
	        // validation successful ---------------------------

	        if (Auth::admin()->attempt([ 'username' => $username, 'password' => $password, 'ruk' => $ruk ])) {
	            return Redirect::intended('/');
	        }
	        else if (Auth::customer()->attempt([ 'username' => $username, 'password' => $password, 'ruk' => $ruk, 'is_active' => 'Yes' ])) {
	            return Redirect::intended('/');
	        }
	        else if (Auth::user()->attempt([ 'username' => $username, 'password' => $password, 'ruk' => $ruk, 'is_active' => 'Yes' ])) {
	            return Redirect::intended('/');
	        }

	        // if (Auth::rep()->attempt(['email' => $username, 'password' => $password])) {
	        //     return Redirect::intended('/');
	        // }
	        // else if (Auth::varacc()->attempt(['username' => $username, 'password' => $password])) {
	        //     return Redirect::intended('/');
	        // }
	        // else if (Auth::admin()->attempt([ 'username' => $username, 'password' => $password, 'ruk' => $ruk ])) {
	        //     return Redirect::intended('/');
	        // }
	        // else if (Auth::admin()->attempt([ 'email' => $username, 'password' => $password, 'ruk' => $ruk ])) {
	        //     return Redirect::intended('/');
	        // }
	 
	        return Redirect::back()
	            ->withInput()
	            ->withErrors(array('loginerror' => 'Invalid credentials.'));

	    }

	}

}
