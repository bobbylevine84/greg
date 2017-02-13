<?php

class CarrierController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $carrier;

	public function __construct(Carrier $carrier) {

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

		$this->carrier = $carrier;
		//$this->ppg 	   = 20;
		$this->menu = 'carrier';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'carrier_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_CARRIERSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_CARRIERSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_CARRIERSEARCH', $params);

        $carriers = $this->carrier->search($pgn, $this->ppg, $params);

        return $this->setView('carrier.index', [ 'params' => $params, 'records' => $carriers ]);
    }


    public function getCreate() {
		$carrier = new Carrier();
		$carrier->is_active = 'Yes';

		$customers = CUSTOMER::all()->lists('comp_name', '_id');

        return $this->setView('carrier.create', [ 'record' => $carrier, 'customers' => $customers ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	if( !$this->carrier->populate($input)->isValid($input, 'create', 0) ) {
    	//if( !$this->carrier->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->carrier->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->carrier->savecarrier()) {

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

		$carrier = Carrier::find($id);

		$customers = CUSTOMER::all()->lists('comp_name', '_id');

		$selcusts = $carrier->customers->lists('_id');

        return $this->setView('carrier.edit', [ 'record' => $carrier, 'customers' => $customers, 'selcusts' => $selcusts ]);
    }

    public function postUpdate($id) {

	    // find the carrier
	    $this->carrier = Carrier::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->carrier->populate($input)->isValid('update', $id) ) {
    	//if( !$this->carrier->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->carrier->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->carrier->savecarrier()) {

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
		Carrier::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::route('carrier.index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_CARRIERSEARCH');
    	echo 'all params flushed...';
    }

}
