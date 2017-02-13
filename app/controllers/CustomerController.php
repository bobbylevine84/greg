<?php

class CustomerController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $customer;

	public function __construct(CUSTOMER $customer) {

		parent::__construct();

		// Superadmin Access
		$this->beforeFilter(function() {
			$app = App::make('myApp');
			if($app->isSU)
				return Redirect::to('error')
						->withErrors([
										'errorcode'  => '500',
										'errormsg'   => 'Oops! You have do not have access to the resource.',
										'suggestion' => 'Please try a different page.'
									]);
		}, array('only' => ['getMyaccount', 'postUpdatemyaccount', 'getChangepassword', 'postUpdatepassword', 'getShowaccount', 'getCompany', 'postUpdatecompany']));

		// Customer Access
		$this->beforeFilter(function() {
			$app = App::make('myApp');
			if($app->utype == 'CUSTOMER')
				return Redirect::to('error')
						->withErrors([
										'errorcode'  => '500',
										'errormsg'   => 'Oops! You have do not have access to the resource.',
										'suggestion' => 'Please try a different page.'
									]);
		}, array('except' => ['getMyaccount', 'postUpdatemyaccount', 'getChangepassword', 'postUpdatepassword', 'getShowaccount', 'getCompany', 'postUpdatecompany']));

		// Customer Access
		$this->beforeFilter(function() {
			$app = App::make('myApp');
			if($app->utype == 'USER')
				return Redirect::to('error')
						->withErrors([
										'errorcode'  => '500',
										'errormsg'   => 'Oops! You have do not have access to the resource.',
										'suggestion' => 'Please try a different page.'
									]);
		}, array('except' => ['getCompany', 'postUpdatecompany']));

		$this->customer = $customer;
		//$this->ppg 	   = 20;
		$this->menu = 'customer';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'comp_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_CUSTOMERSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_CUSTOMERSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_CUSTOMERSEARCH', $params);

        $customers = $this->customer->search($pgn, $this->ppg, $params);

        return $this->setView('customer.index', [ 'params' => $params, 'records' => $customers ]);
    }


    public function getCreate() {
		$customer = new CUSTOMER();
		$customer->is_active = 'Yes';

        return $this->setView('customer.create', [ 'record' => $customer ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	if( !$this->customer->populate($input)->isValid($input, 'create', 0) ) {
    	//if( !$this->customer->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->customer->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->customer->createaccount()) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
							//'payload' => [ 'frm-success' => 'Record saved successfully.' ]
							'payload' => ''
						];

			return Response::json($response);
		}

		$response = [
						'status'  => 'error',
						'payload' => [ 'frm-error' => 'Could not save record.' ]
					];

		return Response::json($response);
    }


    public function getEdit($id) {

		$customer = CUSTOMER::find($id);

        return $this->setView('customer.edit', [ 'record' => $customer ]);
    }

    public function postUpdate($id) {

	    // find the customer
	    $this->customer = CUSTOMER::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->customer->populate($input)->isValid('update', $id) ) {
    	//if( !$this->customer->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->customer->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->customer->save()) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
							//'payload' => [ 'frm-success' => 'Record saved successfully.' ]
							'payload' => ''
						];

			return Response::json($response);
		}

		$response = [
						'status'  => 'error',
						'payload' => [ 'frm-error' => 'Could not save record.' ]
					];

		return Response::json($response);
    }

    public function getMyaccount() {

		$app = App::make('myApp');
		$customer = CUSTOMER::find($app->uid);

        return $this->setView('customer.myaccount', [ 'record' => $customer ]);
    }

    public function postUpdatemyaccount() {

	    // find the customer
		$app = App::make('myApp');
		$this->customer = CUSTOMER::find($app->uid);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->customer->populate($input)->isValid('updateaccount', $app->uid) ) {

			$errormessages = getVErrorMessages($this->customer->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->customer->save()) {

			$response = [
							'status'  => 'success',
							'payload' => [ 'frm-success' => 'Record saved successfully.' ]
						];

			return Response::json($response);

		}

		$response = [
						'status'  => 'error',
						'payload' => [ 'frm-error' => 'Could not save record.' ]
					];

		return Response::json($response);
    }


    public function getChangepassword() {
    	$app = App::make('myApp');

		$customer = CUSTOMER::find($app->uid);

        return $this->setView('customer.changepassword', [ 'record' => $customer]);
    }


    public function postUpdatepassword() {
    	$app = App::make('myApp');
    	//if($app->isSU) return Redirect::to('/');

		$this->customer = CUSTOMER::find($app->uid);

    	// get the previous password
    	$prev_paswd = $this->customer->password;

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->customer->populate($input)->isValid('updatepassword', $app->uid) ) {

			$errormessages = getVErrorMessages($this->customer->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);

    	}
    	elseif(Hash::check($this->customer->password, $prev_paswd)) {
			$response = [
							'status'  => 'error',
							'payload' => [ 'frm-error' => 'Please enter a password other than your previous password.' ]
						];

			return Response::json($response);
    	}
		// save and generate success message
		elseif($this->customer->save()) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
							'payload' => '',
							//'payload' => [ 'frm-success' => 'Record saved successfully.' ]
						];

			return Response::json($response);
		}

		$response = [
						'status'  => 'error',
						'payload' => [ 'frm-error' => 'Could not save record.' ]
					];

		return Response::json($response);
    }

    public function getCompany() {

		$app = App::make('myApp');
		$customer = CUSTOMER::find($app->custAdminID);

		$this->menu = 'company';
        return $this->setView('customer.company', [ 'record' => $customer ]);
    }

    public function postUpdatecompany() {

	    // find the customer
		$app = App::make('myApp');
		$this->customer = CUSTOMER::find($app->custAdminID);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->customer->populate($input)->isValid('updateaccount', $app->uid) ) {

			$errormessages = getVErrorMessages($this->customer->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->customer->save()) {

			$response = [
							'status'  => 'success',
							'payload' => [ 'frm-success' => 'Record saved successfully.' ]
						];

			return Response::json($response);

		}

		$response = [
						'status'  => 'error',
						'payload' => [ 'frm-error' => 'Could not save record.' ]
					];

		return Response::json($response);
    }


    public function getShowaccount($id) {

		$app = App::make('myApp');
		$customer = CUSTOMER::find($app->uid);

        return $this->setView('customer.showaccount', [ 'record' => $customer ]);
    }

	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_CUSTOMERSEARCH');
    	echo 'all params flushed...';
    }

}