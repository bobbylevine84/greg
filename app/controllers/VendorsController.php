<?php

class VendorsController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $vendors;

	public function __construct(Vendors $vendors) {

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

		$this->vendors = $vendors;
		//$this->ppg 	   = 20;
		$this->menu = 'vendor';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'vendor_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_VENDORSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_VENDORSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_VENDORSEARCH', $params);

        $vendorss = $this->vendors->search($pgn, $this->ppg, $params);

        return $this->setView('vendors.index', [ 'params' => $params, 'records' => $vendorss ]);
    }


    public function getCreate() {
		$vendors = new Vendors();
		$vendors->is_active = 'Yes';

		$customers = CUSTOMER::all()->lists('comp_name', '_id');

        return $this->setView('vendors.create', [ 'record' => $vendors, 'customers' => $customers ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	if( !$this->vendors->populate($input)->isValid($input, 'create', 0) ) {
    	//if( !$this->vendors->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->vendors->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->vendors->savevendor()) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
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

		$vendors = Vendors::find($id);

		$customers = CUSTOMER::all()->lists('comp_name', '_id');

		$selcusts = $vendors->customers->lists('_id');

        return $this->setView('vendors.edit', [ 'record' => $vendors, 'customers' => $customers, 'selcusts' => $selcusts ]);
    }

    public function postUpdate($id) {

	    // find the vendors
	    $this->vendors = Vendors::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->vendors->populate($input)->isValid('update', $id) ) {
    	//if( !$this->vendors->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->vendors->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->vendors->savevendor()) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
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

    public function getDestroy($id) {
    	// fetch and delete the record
		Vendors::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::route('vendors.index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_VENDORSEARCH');
    	echo 'all params flushed...';
    }

}
