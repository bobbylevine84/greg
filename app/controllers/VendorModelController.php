<?php

class VendorModelController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $vendormodel;

	public function __construct(VendorModel $vendormodel) {

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

		$this->vendormodel = $vendormodel;
		//$this->ppg 	   = 20;
		$this->menu = 'vmodel';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'tbl_vendor.vendor_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_VENDORMODELSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_VENDORMODELSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_VENDORMODELSEARCH', $params);

        $vendormodels = $this->vendormodel->search($pgn, $this->ppg, $params);

        return $this->setView('vendormodel.index', [ 'params' => $params, 'records' => $vendormodels ]);
    }


    public function getCreate() {
		$vendormodel = new VendorModel();
		$vendormodel->is_active = 'Yes';

		$vendors = Vendors::isActive()->get()->lists('vendor_name', '_id');
		$vendors = [ null => 'Select Vendor' ] + $vendors;

		$features = VendorModelFeature::where('ft_level', '1')->lists('ft_label', '_id');

        return $this->setView('vendormodel.create', [ 'record' => $vendormodel, 'vendors' => $vendors, 'features' => $features ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	if( !$this->vendormodel->populate($input)->isValid($input, 'create', 0) ) {
    	//if( !$this->vendormodel->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->vendormodel->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->vendormodel->savemodel()) {

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

    	$id = Input::get('vid', 0);
    	$customers = [];
    	$vendor = Vendors::find($id);
    	if($vendor)
    		$customers = $vendor->customers->lists('comp_name', '_id');

    	return $this->setView('vendormodel._customers', [ 'customers' => $customers, 'selcustomers' => [] ] );
    }

    public function getEdit($id) {

		$vendormodel = VendorModel::find($id);

		$vendors = Vendors::isActive()->get()->lists('vendor_name', '_id');
		$vendors = [ null => 'Select Vendor' ] + $vendors;

		$features = VendorModelFeature::where('ft_level', '1')->lists('ft_label', '_id');

		$selfeatures = $vendormodel->modelfeatures->lists('_id');

		$customers = $vendormodel->vendor->customers->lists('comp_name', '_id');

		$selcustomers = $vendormodel->customers->lists('_id');

        return $this->setView('vendormodel.edit', [ 
        											'record' => $vendormodel, 
        											'vendors' => $vendors, 
        											'features' => $features, 
        											'selfeatures' => $selfeatures, 
        											'customers' => $customers, 
        											'selcustomers' => $selcustomers, 
        										]);
    }

    public function postUpdate($id) {

	    // find the vendormodel
	    $this->vendormodel = VendorModel::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->vendormodel->populate($input)->isValid('update', $id) ) {
    	//if( !$this->vendormodel->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->vendormodel->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->vendormodel->savemodel()) {

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
		VendorModel::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::route('vendormodel.index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_VENDORMODELSEARCH');
    	echo 'all params flushed...';
    }

}
