<?php

class ProvisionController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $provision;

	public function __construct(Provision $provision) {

		parent::__construct();

		$this->beforeFilter(function() {
			$app = App::make('myApp');
			if(!$app->isCustAdmin && $app->utype=='USER')
				return Redirect::to('error')
						->withErrors([
										'errorcode'  => '500',
										'errormsg'   => 'Oops! You have do not have access to the resource.',
										'suggestion' => 'Please try a different page.'
									]);
		}, array('except' => ['anyIndex']));

		$this->beforeFilter(function() {
			$app = App::make('myApp');
			if(!$app->isCustAdmin && $app->utype!='USER')
				return Redirect::to('error')
						->withErrors([
										'errorcode'  => '500',
										'errormsg'   => 'Oops! You have do not have access to the resource.',
										'suggestion' => 'Please try a different page.'
									]);
		});

		// $this->beforeFilter(function() {
		// 	$app = App::make('myApp');
		// 	if(!$app->isCustAdmin)
		// 		return Redirect::to('error')
		// 				->withErrors([
		// 								'errorcode'  => '500',
		// 								'errormsg'   => 'Oops! You have do not have access to the resource.',
		// 								'suggestion' => 'Please try a different page.'
		// 							]);
		// });

		$this->provision = $provision;
		$this->cards_per_radio = 1;
		//$this->ppg 	   = 20;
		$this->menu = 'provision';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'tbl_template.tmpl_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_PROVISIONSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_PROVISIONSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_PROVISIONSEARCH', $params);

        $provisions = $this->provision->search($pgn, $this->ppg, $params);

        return $this->setView('provision.index', [ 'params' => $params, 'records' => $provisions ]);
    }

    public function getTemplates() {
		$app = App::make('myApp');
		$custAdmin = $app->custAdminID;

    	$tid = Input::get('tid', '0');

		$template = Templates::find($tid);

		$radioinv = $carrierinv = $allowed_deployments = $fulfilled_radios = 0;
		$needvendorsno = $template->needvendorsno();
		$needcarriersno = $template->needcarriersno();

		if($needvendorsno && $needcarriersno) {
			$radioinv = $template->vendormodel->inventory()
												->where('status', 'Available')
												->where('customer_id', $custAdmin)
												->count();
			$carrierinv = $template->carriermodel->inventory()
													->where('status', 'Available')
													->where('customer_id', $custAdmin)
													->count();
			$fulfilled_radios = intval( $carrierinv / $template->cards_per_radio );
			$allowed_deployments = min([ $radioinv, $fulfilled_radios ]);
		}
		elseif($needvendorsno && !$needcarriersno) {
			$radioinv = $allowed_deployments = $template->vendormodel->inventory()
															->where('status', 'Available')
															->where('customer_id', $custAdmin)
															->count();
		}
		elseif(!$needvendorsno && $needcarriersno) {
			$carrierinv = $template->carriermodel->inventory()
													->where('status', 'Available')
													->where('customer_id', $custAdmin)
													->count();
			$allowed_deployments = intval( $carrierinv / $template->cards_per_radio );
		}

        return $this->setView('provision._template', [
        											'record' => $template,
        											'radioinv' => $radioinv,
        											'carrierinv' => $carrierinv,
        											'allowed_deployments' => $allowed_deployments,
        											'cards_per_radio' => $template->cards_per_radio,
        											'customer_id' => $template->customer_id,
        											'needvendorsno' => $needvendorsno, 
        											'needcarriersno' => $needcarriersno, 
        										]);
    }

    public function getCreate() {

    	$app = App::make('myApp');

		$provision = new Provision();
		$provision->is_active = 'Yes';

		if($app->isSU) $provision->customer_id = null;
		else $provision->customer_id = $app->custAdminID;

		$templates = [];
		// filtering vendor list on user type
		// if($app->isSU) $templates = Templates::isActive()->get()->lists('tmpl_name', '_id');
		// elseif($app->isCustAdmin) $templates = CUSTOMER::find($app->custAdminID)->templates()->isActive()->get()->lists('tmpl_name', '_id');
		$templates = $this->administrator->templates()->isActive()->get()->lists('tmpl_name', '_id');
		$templates = [ null => 'Select Template' ] + $templates;

        return $this->setView('provision.create', [ 'record' => $provision, 'templates' => $templates, ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

		$errormessages = [];

    	// fill and save the data after auto validation
    	//if( !$this->provision->populate($input)->isValid('create', 0) ) {
    	if( !$this->provision->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->provision->vErrors);

			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		$saveresult = $this->provision->saveprovision($input);
		if( $saveresult === TRUE ) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
							'payload' => ''
						];

			return Response::json($response);
		}
		else if( $saveresult === FALSE ) {
			$response = [
							'status'  => 'error',
							'payload' => [ 'frm-error' => 'Could not save record.' ]
						];

			return Response::json($response);
		}

		$response = [
						'status'  => 'error',
						'payload' => [ 'frm-error' => $saveresult ]
					];

		return Response::json($response);
    }

	public function getRelease($id) {
		// fetch and release the record
		$provision = Provision::find($id);
		if($provision->releaseprovision()) Session::flash('flash-done', "All 'Staged' inventory released successfully.");
		else Session::flash('flash-error', "Could not 'Release' provision.");
		return Redirect::route('provision.index');
	}

	public function getArchive($id) {
		// fetch and archieve the record
		$provision = Provision::find($id);

		$completeditems = $provision->deployeditems()->count() + $provision->releaseditems()->count();

		if(($provision->template->needvendorsno() || $provision->template->needcarriersno()) && 
			$provision->no_of_deploy > $completeditems) {
			Session::flash('flash-error', 'There is "Staged" inventory for ' . $provision->template->tmpl_name . '. You cannot Archive.');
		}
		else {
			$provision->is_archieved = 'Yes';
			if($provision->save()) Session::flash('flash-done', "Record archived successfully.");
			else Session::flash('flash-error', "Could not archive record.");
		}
		return Redirect::route('provision.index');
	}


	// public function getEdit($id) {

	// 	$app = App::make('myApp');

	// 	$provision = Provision::find($id);

	// 	$groups = Groups::isActive()->get()->lists('group_name', '_id');

	// 	$selgroups = $provision->groups->lists('_id');

	// 	$vendors = [];
	// 	// filtering vendor list on user type
	// 	if($app->isSU) $vendors = Vendors::isActive()->has('models')->get()->lists('vendor_name', '_id');
	// 	elseif($app->isCustAdmin) $vendors = CUSTOMER::find($app->custAdminID)->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
	// 	$vendors = [ null => 'Select Vendor' ] + $vendors;

	// 	$vendormodels = VendorModel::isActive()->where('vendor_id', $provision->vendor_id)->get()->lists('model_name', '_id');
	// 	$vendormodels = [ null => 'Select Vendor Model' ] + $vendormodels;

	// 	$carriers = [];
	// 	// filtering vendor list on user type
	// 	if($app->isSU) $carriers = Carrier::isActive()->has('models')->get()->lists('carrier_name', '_id');
	// 	elseif($app->isCustAdmin) $carriers = CUSTOMER::find($app->custAdminID)->carriers()->isActive()->has('models')->get()->lists('carrier_name', '_id');
	// 	$carriers = [ null => 'Select Vendor' ] + $carriers;

	// 	$carriermodels = CarrierModel::isActive()->where('carrier_id', $provision->carrier_id)->get()->lists('model_name', '_id');
	// 	$carriermodels = [ null => 'Select Carrier Model' ] + $carriermodels;

	// 	$customers = CUSTOMER::isActive()->get()->lists('comp_name', '_id');
	// 	$customers = [ null => 'Select Customer' ] + $customers;

	// 	return $this->setView('provision.edit', [
	// 											'record' => $provision,
	// 											'groups' => $groups,
	// 											'selgroups' => $selgroups,
	// 											'vendors' => $vendors,
	// 											'vendormodels' => $vendormodels,
	// 											'carriers' => $carriers,
	// 											'carriermodels' => $carriermodels,
	// 											'customers' => $customers,
	// 										]);


	// }

	// public function postUpdate($id) {

	//     // find the provision
	//     $this->provision = Provision::find($id);

	// 	// capture all user input data
	// 	$input = Input::all();

	// 	// validate the data
	// 	//if( !$this->provision->populate($input)->isValid('update', $id) ) {
	// 	if( !$this->provision->isValid($input, 'update', $id) ) {

	// 		$errormessages = [];

	// 		$emsgs = getVErrorMessages($this->provision->vErrors);
	// 		foreach($emsgs as $f => $emsg) {
	// 			if(str_contains($f, 'vmf.') || str_contains($f, 'cmf.')) {
	// 				$index = str_replace( ['vmf.', 'cmf.', '.'], ['vmf[', 'cmf[', ']['], $f ) . ']';
	// 				$errormessages[$index] = $emsg;
	// 			}
	// 			else $errormessages[$f] = $emsg;
	// 		}

	// 		//$errormessages = getVErrorMessages($this->provision->vErrors);

	// 		$response = [
	// 						'status'  => 'verror',
	// 						'payload' => $errormessages
	// 					];

	// 		return Response::json($response);
	// 	}

	// 	// save and generate success message
	// 	if($this->provision->updateprovision($input)) {

	// 		Session::flash('flash-done', 'Record saved successfully.');

	// 		$response = [
	// 						'status'  => 'success',
	// 						'payload' => ''
	// 					];

	// 		return Response::json($response);
	// 	}

	// 	$response = [
	// 					'status'  => 'error',
	// 					'payload' => [ 'frm-error' => 'Could not save record.' ]
	// 				];

	// 	return Response::json($response);
	// }

	// public function getDestroy($id) {
	// 	// fetch and delete the record
	// 	Provision::destroy($id);
	// 	Session::flash('flash-done', 'Record deleted successfully.');
	// 	return Redirect::route('provision.index');
	// }

	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_PROVISIONSEARCH');
    	echo 'all params flushed...';
    }

}
