<?php

class TemplatesController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $templates;

	public function __construct(Templates $templates) {

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
		}, array('except' => ['anyIndex', 'getView']));

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

		$this->templates = $templates;
		//$this->ppg 	   = 20;
		$this->menu = 'template';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'tmpl_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_TEMPLATESEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_TEMPLATESEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_TEMPLATESEARCH', $params);

        $templatess = $this->templates->search($pgn, $this->ppg, $params);

        return $this->setView('templates.index', [ 'params' => $params, 'records' => $templatess ]);
    }

    public function getVendormodels() {
    	$vid = Input::get('vid', '0');
    	//$models = VendorModel::isActive()->where('vendor_id', $vid)->has('modelfeatures')->get()->lists('model_name', '_id');
    	$models = $this->administrator->vendormodels()->isActive()
    													->where('vendor_id', $vid)
    													//->has('modelfeatures')
    													->get()
    													->lists('model_name', '_id');
        $models = [null => 'Select Vendor Model'] + $models;

        return $this->setView('templates._models', [ 'models' => $models, ]);
    }

    public function getCarriermodels() {
    	$cid = Input::get('cid', '0');
    	//$models = CarrierModel::isActive()->where('carrier_id', $cid)->has('modelfeatures')->get()->lists('model_name', '_id');
    	$models = $this->administrator->carriermodels()->isActive()
    													->where('carrier_id', $cid)
    													//->has('modelfeatures')
    													->get()
    													->lists('model_name', '_id');
        $models = [null => 'Select Carrier Model'] + $models;

        return $this->setView('templates._models', [ 'models' => $models, ]);
    }

    public function getVendormodelallfeatures() {
    	$mid = Input::get('mid', '0');
    	$tid = Input::get('tmp', '0');

    	$features = VendorModel::find($mid)->modelfeatures()->isActive()->isLevel1()->get()->lists('ft_label', '_id');
		$features = [ null => 'Select Feature' ] + $features;

        return $this->setView('templates._features', [ 'records' => $features ]);
    }

    public function getCarriermodelallfeatures() {
    	$mid = Input::get('mid', '0');
    	$tid = Input::get('tmp', '0');

    	$features = CarrierModel::find($mid)->modelfeatures()->isActive()->isLevel1()->get()->lists('ft_label', '_id');
		$features = [ null => 'Select Feature' ] + $features;

        return $this->setView('templates._features', [ 'records' => $features ]);
    }

    public function getVendormodelfeature() {
		$fid = Input::get('fid', '0');
		$knt = Input::get('knt', '0');

    	$feature = VendorModelFeature::find($fid);

    	if($feature && $feature->ft_unique == 'Yes' && $knt >= 1)
    		return 'UNIQUEERROR';

    	$ft_fld_part = $ft_lbl_part = '';
    	if($feature->ft_unique != 'Yes') {
    		$knt++;
    		$ft_fld_part = '_' . $knt;
    		$ft_lbl_part = ' ' . $knt;
    	}

		return $this->setView('templates._vmfform', [ 
														'records' => [ $feature ], 
														'ft_fld_part' => $ft_fld_part, 
														'ft_lbl_part' => $ft_lbl_part, 
													]);
    }

    public function getCarriermodelfeature() {
		$fid = Input::get('fid', '0');
		$knt = Input::get('knt', '0');

    	$feature = CarrierModelFeature::find($fid);

    	if($feature && $feature->ft_unique == 'Yes' && $knt >= 1)
    		return 'UNIQUEERROR';

    	$ft_fld_part = $ft_lbl_part = '';
    	if($feature->ft_unique != 'Yes') {
    		$knt++;
    		$ft_fld_part = '_' . $knt;
    		$ft_lbl_part = ' ' . $knt;
    	}

		return $this->setView('templates._cmfform', [ 
														'records' => [ $feature ], 
														'ft_fld_part' => $ft_fld_part, 
														'ft_lbl_part' => $ft_lbl_part, 
													]);
    }

    public function getVendormodelfeaures() {
    	$mid = Input::get('mid', '0');
    	$tid = Input::get('tmp', '0');

		$template = Templates::find($tid);
		if($template && $template->vendor_model_id == $mid) {
			$features = $template->vendormodelfeatures()->isLevel1()->get();

			return $this->setView('templates._editvmfform', [ 'records' => $features, 'vmodel' => $mid ]);
		}

    	$features = VendorModel::find($mid)->modelfeatures()->isActive()->get();

        return $this->setView('templates._vmfform', [ 'records' => $features ]);
    }

    public function getCarriermodelfeaures() {
    	$mid = Input::get('mid', '0');
    	$tid = Input::get('tmp', '0');

		$template = Templates::find($tid);
		if($template && $template->carrier_model_id == $mid) {
			$features = $template->carriermodelfeatures()->isLevel1()->get();

			return $this->setView('templates._editcmfform', [ 'records' => $features, 'cmodel' => $mid ]);
		}

    	$features = CarrierModel::find($mid)->modelfeatures()->isActive()->get();

        return $this->setView('templates._cmfform', [ 'records' => $features, ]);
    }


    public function getCreate() {

    	$app = App::make('myApp');

		$templates = new Templates();
		$templates->is_active 		 = 'Yes';
		$templates->need_vendor_sku  = 'Yes';
		$templates->need_carrier_sku = 'Yes';

		if($app->isSU) $templates->customer_id = null;
		else $templates->customer_id = $app->custAdminID;

		$groups = Groups::isActive()->where('cust_id', $app->custAdminID)->get()->lists('group_name', '_id');

		$vendors = [];
		// filtering vendor list on user type
		// if($app->isSU) $vendors = Vendors::isActive()->has('models')->get()->lists('vendor_name', '_id');
		// elseif($app->isCustAdmin) $vendors = CUSTOMER::find($app->custAdminID)->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
        $vendors = $this->administrator->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
		$vendors = [ null => 'Select Vendor' ] + $vendors;

		$vendormodels = [ null => 'Select Vendor Model' ];

		$carriers = [];
		// filtering vendor list on user type
		// if($app->isSU) $carriers = Carrier::isActive()->has('models')->get()->lists('carrier_name', '_id');
		// elseif($app->isCustAdmin) $carriers = CUSTOMER::find($app->custAdminID)->carriers()->isActive()->has('models')->get()->lists('carrier_name', '_id');
        $carriers = $this->administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
		$carriers = [ null => 'Select Carrier' ] + $carriers;

		$carriermodels = [ null => 'Select Carrier Model' ];

		$customers = CUSTOMER::isActive()->get()->lists('comp_name', '_id');
		$customers = [ null => 'Select Customer' ] + $customers;

		$vendormodelftrs = [ null => 'Select Feature' ];
		$carriermodelftrs = [ null => 'Select Feature' ];

        return $this->setView('templates.create', [
        										'record' => $templates,
        										'groups' => $groups,
        										'vendors' => $vendors,
        										'vendormodels' => $vendormodels,
        										'carriers' => $carriers,
        										'carriermodels' => $carriermodels,
        										'customers' => $customers,
        										'vendormodelftrs' => $vendormodelftrs, 
        										'carriermodelftrs' => $carriermodelftrs, 
        									]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	//if( !$this->templates->populate($input)->isValid('create', 0) ) {
    	if( !$this->templates->isValid($input, 'create', 0) ) {

			$errormessages = [];

			$emsgs = getVErrorMessages($this->templates->vErrors);
			foreach($emsgs as $f => $emsg) {
				if(str_contains($f, 'vmf.') || str_contains($f, 'cmf.')) {
					$index = str_replace( ['vmf.', 'cmf.', '.'], ['vmf[', 'cmf[', ']['], $f ) . ']';
					$errormessages[$index] = $emsg;
				}
				else $errormessages[$f] = $emsg;
			}

			//$errormessages = getVErrorMessages($this->templates->vErrors);

			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->templates->savetemplate($input)) {

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

    	$app = App::make('myApp');

		$templates = Templates::find($id);

		$groups = Groups::isActive()->where('cust_id', $app->custAdminID)->get()->lists('group_name', '_id');

		$selgroups = $templates->groups->lists('_id');

		$vendors = [];
		// filtering vendor list on user type
		// if($app->isSU) $vendors = Vendors::isActive()->has('models')->get()->lists('vendor_name', '_id');
		// elseif($app->isCustAdmin) $vendors = CUSTOMER::find($app->custAdminID)->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
        $vendors = $this->administrator->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
		$vendors = [ null => 'Select Vendor' ] + $vendors;

		//$vendormodels = VendorModel::isActive()->where('vendor_id', $templates->vendor_id)->get()->lists('model_name', '_id');
		$vendormodels = $this->administrator->vendormodels()->isActive()
														->where('vendor_id', $templates->vendor_id)
														->get()
														->lists('model_name', '_id');
		// checking if current model id is present, if not, adding it
		if(!array_key_exists($templates->vendor_model_id, $vendormodels))
			$vendormodels[$templates->vendor_model_id] = $templates->vendormodel->model_name;
		$vendormodels = [ null => 'Select Vendor Model' ] + $vendormodels;

		$carriers = [];
		// filtering vendor list on user type
		// if($app->isSU) $carriers = Carrier::isActive()->has('models')->get()->lists('carrier_name', '_id');
		// elseif($app->isCustAdmin) $carriers = CUSTOMER::find($app->custAdminID)->carriers()->isActive()->has('models')->get()->lists('carrier_name', '_id');
        $carriers = $this->administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
		$carriers = [ null => 'Select Carrier' ] + $carriers;

		$carriermodels = [ null => 'Select Carrier Model' ];

		//$carriermodels = CarrierModel::isActive()->where('carrier_id', $templates->carrier_id)->get()->lists('model_name', '_id');
		$carriermodels = $this->administrator->carriermodels()->isActive()
																->where('carrier_id', $templates->carrier_id)
																->get()
																->lists('model_name', '_id');

		// checking if carrier exists for current template
		if($templates->carrier) {
			// checking if current model id is present, if not, adding it
			if(!array_key_exists($templates->carrier_model_id, $carriermodels)) {
				$carriermodels[$templates->carrier_model_id] = $templates->carriermodel->model_name;
			}
		}

		$carriermodels = [ null => 'Select Carrier Model' ] + $carriermodels;

		$customers = CUSTOMER::isActive()->get()->lists('comp_name', '_id');
		$customers = [ null => 'Select Customer' ] + $customers;

		$vendormodelftrs = [ null => 'Select Feature' ]
							+ $templates->vendormodel->modelfeatures()->isActive()->isLevel1()->get()->lists('ft_label', '_id');
		$carriermodelftrs = [ null => 'Select Feature' ];
		if($templates->carrier)
			$carriermodelftrs = $carriermodelftrs + $templates->carriermodel->modelfeatures()->isActive()->isLevel1()->get()->lists('ft_label', '_id');

		$ft_fld_part = $ft_lbl_part = '';

        return $this->setView('templates.edit', [
        										'record' => $templates,
        										'groups' => $groups,
        										'selgroups' => $selgroups,
        										'vendors' => $vendors,
        										'vendormodels' => $vendormodels,
        										'carriers' => $carriers,
        										'carriermodels' => $carriermodels,
        										'customers' => $customers,
        										'vendormodelftrs' => $vendormodelftrs, 
        										'carriermodelftrs' => $carriermodelftrs, 
												'ft_fld_part' => $ft_fld_part, 
												'ft_lbl_part' => $ft_lbl_part, 
        									]);
    }

    public function postUpdate($id) {

	    // find the templates
	    $this->templates = Templates::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	//if( !$this->templates->populate($input)->isValid('update', $id) ) {
    	if( !$this->templates->isValid($input, 'update', $id) ) {

			$errormessages = [];

			$emsgs = getVErrorMessages($this->templates->vErrors);
			foreach($emsgs as $f => $emsg) {
				if(str_contains($f, 'vmf.') || str_contains($f, 'cmf.')) {
					$index = str_replace( ['vmf.', 'cmf.', '.'], ['vmf[', 'cmf[', ']['], $f ) . ']';
					$errormessages[$index] = $emsg;
				}
				else $errormessages[$f] = $emsg;
			}

			//$errormessages = getVErrorMessages($this->templates->vErrors);

			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->templates->updatetemplate($input)) {

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

    public function anyCopy($id=0) {

    	$app = App::make('myApp');

		$templates = Templates::find($id);
		$templates->tmpl_name = null;

		$groups = Groups::isActive()->where('cust_id', $app->custAdminID)->get()->lists('group_name', '_id');

		$selgroups = $templates->groups->lists('_id');

		$vendors = [];
		// filtering vendor list on user type
		// if($app->isSU) $vendors = Vendors::isActive()->has('models')->get()->lists('vendor_name', '_id');
		// elseif($app->isCustAdmin) $vendors = CUSTOMER::find($app->custAdminID)->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
        $vendors = $this->administrator->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
		$vendors = [ null => 'Select Vendor' ] + $vendors;

		$vendormodels = VendorModel::isActive()->where('vendor_id', $templates->vendor_id)->get()->lists('model_name', '_id');
		$vendormodels = [ null => 'Select Vendor Model' ] + $vendormodels;

		$carriers = [];
		// filtering vendor list on user type
		// if($app->isSU) $carriers = Carrier::isActive()->has('models')->get()->lists('carrier_name', '_id');
		// elseif($app->isCustAdmin) $carriers = CUSTOMER::find($app->custAdminID)->carriers()->isActive()->has('models')->get()->lists('carrier_name', '_id');
        $carriers = $this->administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
		$carriers = [ null => 'Select Carrier' ] + $carriers;

		$carriermodels = [ null => 'Select Carrier Model' ];

		$carriermodels = CarrierModel::isActive()->where('carrier_id', $templates->carrier_id)->get()->lists('model_name', '_id');
		$carriermodels = [ null => 'Select Carrier Model' ] + $carriermodels;

		$customers = CUSTOMER::isActive()->get()->lists('comp_name', '_id');
		$customers = [ null => 'Select Customer' ] + $customers;

		$vendormodelftrs = [ null => 'Select Feature' ]
							+ $templates->vendormodel->modelfeatures()->isActive()->isLevel1()->get()->lists('ft_label', '_id');
		$carriermodelftrs = [ null => 'Select Feature' ];
		if($templates->carrier)
			$carriermodelftrs = $carriermodelftrs + $templates->carriermodel->modelfeatures()->isActive()->isLevel1()->get()->lists('ft_label', '_id');

		$ft_fld_part = $ft_lbl_part = '';

        return $this->setView('templates.copy', [
        										'record' => $templates,
        										'groups' => $groups,
        										'selgroups' => $selgroups,
        										'vendors' => $vendors,
        										'vendormodels' => $vendormodels,
        										'carriers' => $carriers,
        										'carriermodels' => $carriermodels,
        										'customers' => $customers,
        										'vendormodelftrs' => $vendormodelftrs, 
        										'carriermodelftrs' => $carriermodelftrs, 
												'ft_fld_part' => $ft_fld_part, 
												'ft_lbl_part' => $ft_lbl_part, 
        									]);
    }


    public function getView($id) {

    	$app = App::make('myApp');

		// filtering for normal(operator) users
		// showing only those records which they are related to
		if(!$app->isCustAdmin) {
			$tmps = [];// container for templates which user has access to
			$appUser = USER::find($app->uid);// get logged in user

			$uts = $appUser->templates();// get all templates for logged in user

			// loop for each template and get the id out of it
			if(count($uts)>0) foreach($uts as $t) $tmps[] = $t->_id;

			if(!in_array($id, $tmps)) {
				return Redirect::to('error')
						->withErrors([
										'errorcode'  => '404',
										'errormsg'   => 'Oops! Requested record not found.',
										'suggestion' => 'Please try a different record.'
									]);
			}

		}

		$templates = Templates::find($id);

		$groups = Groups::isActive()->where('cust_id', $app->pid)->get()->lists('group_name', '_id');

		$selgroups = $templates->groups->lists('_id');

		$administrator = getTheBoss();

		$vendors = [];
		// filtering vendor list on user type
		// if($app->isSU) $vendors = Vendors::isActive()->has('models')->get()->lists('vendor_name', '_id');
		// elseif($app->isCustAdmin) $vendors = CUSTOMER::find($app->custAdminID)->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
        $vendors = $administrator->vendors()->isActive()->has('models')->get()->lists('vendor_name', '_id');
		$vendors = [ null => 'Select Vendor' ] + $vendors;

		$vendormodels = VendorModel::isActive()->where('vendor_id', $templates->vendor_id)->get()->lists('model_name', '_id');
		$vendormodels = [ null => 'Select Vendor Model' ] + $vendormodels;

		$carriers = [];
		// filtering vendor list on user type
		// if($app->isSU) $carriers = Carrier::isActive()->has('models')->get()->lists('carrier_name', '_id');
		// elseif($app->isCustAdmin) $carriers = CUSTOMER::find($app->custAdminID)->carriers()->isActive()->has('models')->get()->lists('carrier_name', '_id');
        $carriers = $administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
		$carriers = [ null => 'Select Carrier' ] + $carriers;

		$carriermodels = [ null => 'Select Carrier Model' ];

		$carriermodels = CarrierModel::isActive()->where('carrier_id', $templates->carrier_id)->get()->lists('model_name', '_id');
		$carriermodels = [ null => 'Select Carrier Model' ] + $carriermodels;

		$customers = CUSTOMER::isActive()->get()->lists('comp_name', '_id');
		$customers = [ null => 'Select Customer' ] + $customers;

		$ft_fld_part = $ft_lbl_part = '';

        return $this->setView('templates.view', [
        										'record' => $templates,
        										'groups' => $groups,
        										'selgroups' => $selgroups,
        										'vendors' => $vendors,
        										'vendormodels' => $vendormodels,
        										'carriers' => $carriers,
        										'carriermodels' => $carriermodels,
        										'customers' => $customers,
												'ft_fld_part' => $ft_fld_part, 
												'ft_lbl_part' => $ft_lbl_part, 
        									]);


    }

    public function getDestroy($id) {
    	// fetch and delete the record
		Templates::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::route('templates.index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_TEMPLATESEARCH');
    	echo 'all params flushed...';
    }

}
