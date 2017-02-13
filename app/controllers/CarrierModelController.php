<?php

class CarrierModelController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $carriermodel;

	public function __construct(CarrierModel $carriermodel) {

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

		$this->carriermodel = $carriermodel;
		//$this->ppg 	   = 20;
		$this->menu = 'cmodel';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'tbl_carrier.carrier_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_CARRIERMODELSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_CARRIERMODELSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_CARRIERMODELSEARCH', $params);

        $carriermodels = $this->carriermodel->search($pgn, $this->ppg, $params);

        return $this->setView('carriermodel.index', [ 'params' => $params, 'records' => $carriermodels ]);
    }


    public function getCreate() {
		$carriermodel = new CarrierModel();
		$carriermodel->is_active = 'Yes';

		$carriers = Carrier::isActive()->get()->lists('carrier_name', '_id');
		$carriers = [ null => 'Select Carrier' ] + $carriers;

		$features = CarrierModelFeature::where('ft_level', '1')->lists('ft_label', '_id');

        return $this->setView('carriermodel.create', [ 'record' => $carriermodel, 'carriers' => $carriers, 'features' => $features ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	if( !$this->carriermodel->populate($input)->isValid($input, 'create', 0) ) {
    	//if( !$this->carriermodel->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->carriermodel->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->carriermodel->savemodel()) {

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

    public function getCustomers() {

    	$id = Input::get('cid', 0);
    	$customers = [];
    	$carrier = Carrier::find($id);
    	if($carrier)
    		$customers = $carrier->customers->lists('comp_name', '_id');

    	return $this->setView('carriermodel._customers', [ 'customers' => $customers, 'selcustomers' => [] ] );
    }

    public function getEdit($id) {

		$carriermodel = CarrierModel::find($id);

		$carriers = Carrier::isActive()->get()->lists('carrier_name', '_id');
		$carriers = [ null => 'Select Carrier' ] + $carriers;

		$features = CarrierModelFeature::where('ft_level', '1')->lists('ft_label', '_id');

		$selfeatures = $carriermodel->modelfeatures->lists('_id');

		$customers = $carriermodel->carrier->customers->lists('comp_name', '_id');

		$selcustomers = $carriermodel->customers->lists('_id');

        return $this->setView('carriermodel.edit', [ 
        												'record' => $carriermodel, 
        												'carriers' => $carriers, 
        												'features' => $features, 
        												'selfeatures' => $selfeatures, 
	        											'customers' => $customers, 
	        											'selcustomers' => $selcustomers, 
        											]);
    }

    public function postUpdate($id) {

	    // find the carriermodel
	    $this->carriermodel = CarrierModel::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->carriermodel->populate($input)->isValid('update', $id) ) {
    	//if( !$this->carriermodel->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->carriermodel->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->carriermodel->savemodel()) {

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
		CarrierModel::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::route('carriermodel.index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_CARRIERMODELSEARCH');
    	echo 'all params flushed...';
    }

}
