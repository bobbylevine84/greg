<?php

class SAAccountController extends BaseController {

	protected $saaccount;

	public function __construct(SAAccount $saaccount) {

		parent::__construct();

		$this->beforeFilter(function() {
			$app = App::make('myApp');
			if(!$app->isSU)
				return Redirect::to('error')
						->withErrors([
										'errorcode'  => '500',
										'errormsg'   => 'Oops! You have do not have access to the resource.',
										'suggestion' => 'Please try a different page.'
									]);
		});

		$this->saaccount = $saaccount;
		//$this->ppg 	   = 20;
		$this->menu = '';// for selecting sidemenu
	}

    public function getChangepassword() {
    	$app = App::make('myApp');

		$saaccount = SAAccount::find($app->uid);

        return $this->setView('saaccount.changepassword', [ 'record' => $saaccount]);
    }

    public function postUpdatepassword() {
    	$app = App::make('myApp');

		$this->saaccount = SAAccount::find($app->uid);

    	// capture all user input data
    	$input = Input::all();

		$this->saaccount->password = Input::get('password', '');
		$this->saaccount->password_confirmation = Input::get('password_confirmation', '');

    	// validate the data
    	if( !$this->saaccount->isValid('updatepassword', $app->uid) ) {
	        return Redirect::back()
	            ->withInput()
	            ->withErrors($this->saaccount->vErrors);
    	}

		// save and generate success message
		$this->saaccount->save();
		Session::flash('flash-done', 'Password updated successfully.');
		return Redirect::route('saaccount.changepassword');
    }

	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

}
