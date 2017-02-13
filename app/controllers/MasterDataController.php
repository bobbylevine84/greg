<?php

class MasterDataController extends BaseController {

    protected $ft_types;

	public function __construct() {

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

        $this->ft_types = [
                            'Drop-down' => 'Drop-down', 'IP' => 'IP', 'IP Range' => 'IP Range', 'Label' => 'Label', 
                            'Range' => 'Range', 'Text-box' => 'Text-box', 'Text-area' => 'Text-area', 
                        ];

        $this->data_types = [ 'Incrementing' => 'Incrementing', 'Numeric' => 'Numeric', 'Text' => 'Text' ];
        $this->assigned_by = [ null => 'Select', 'Provisioner' => 'Provisioner', 'Radio Admin' => 'Radio Admin' ];

		//$this->ppg 	   = 2;
        $this->menu = 'masterdata';// for selecting sidemenu
	}

	public function anyIndex() { return Redirect::route('masterdata.vendormodelfeature'); }

    public function anyVendormodelfeature() {
		$params = array();
		$page = Input::get('page', 1);
		$clr  = Input::get('btnClear', false);
		$srh  = Input::get('btnSearch', false);
        $srt = [ 'srchOBy' => 'ft_label', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_VENDORMODELFEATURESEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_VENDORMODELFEATURESEARCH', array());

        // merging defaut sorting values
        $params = array_merge($srt, $params);

		Session::put('PARAMS_VENDORMODELFEATURESEARCH', $params);

        $records = VendorModelFeature::search($page, $this->ppg, $params);

        return $this->setView('vendormodelfeature.index', ['params' => $params, 'records' => $records ]);
    }

    public function getNewchildmouldvendormodelfeature() {
        $childKount = Input::get('ck', '0');
        return $this->setView('vendormodelfeature._newchildmould', [ 
                                                                        'ck' => $childKount, 
                                                                        'ft_types' => $this->ft_types, 
                                                                        'data_types' => $this->data_types,
                                                                        'assigned_by' => $this->assigned_by
                                                                    ]);
    }

    public function getCreatevendormodelfeature() {
        $feature = new VendorModelFeature();
        $feature->is_active     = 'Yes';
        $feature->ft_unique     = 'Yes';
        $feature->ft_data_type  = 'Text';
        $feature->ft_type       = 'Text-box';
        $feature->ft_disp_order = VendorModelFeature::where('ft_level', '1')->max('ft_disp_order') + 1;

        return $this->setView('vendormodelfeature.create', [ 
                                                                'record' => $feature, 
                                                                'ft_types' => $this->ft_types, 
                                                                'data_types' => $this->data_types, 
                                                                'assigned_by' => $this->assigned_by
                                                            ]);
    }

    public function postStorevendormodelfeature() {

        // capture all user input data
        $input = Input::all();

        $feature = new VendorModelFeature();

        $all_valid     = true;
        $errormessages = [];
        $child         = isset($input['child']) && is_array($input['child']) ? $input['child'] : [];
        $formlabels    = [];

        if( !$feature->populate($input)->isValid('create', 0) ) {
            $all_valid = false;
            $errormessages = getVErrorMessages($feature->vErrors);
        }

        if(isset($input['ft_label']) && !empty($input['ft_label'])) $formlabels[] = $input['ft_label'];

        foreach ($child as $k => $c) {
            if(isset($c['ft_label']) && !empty($c['ft_label'])) {

                // validating unique labels in form
                if(in_array($c['ft_label'], $formlabels)) {
                    $errormessages['child[' . $k . '][ft_label]'] = 'The Name has already been taken.';
                    $all_valid = false;
                    continue;
                }
                else $formlabels[] = $c['ft_label'];

                $object = new VendorModelFeature();
                if( !$object->populate($c)->isValid('child', 0) ) {
                    $all_valid = false;
                    $emsgs = getVErrorMessages($object->vErrors);
                    foreach($emsgs as $f => $emsg) {
                        $errormessages['child[' . $k . ']['.$f.']'] = $emsg;
                    }
                }
            }
        }

        if($all_valid) {

            if($feature->savefeature($input)) {

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

        $response = [
                        'status'  => 'verror',
                        'payload' => $errormessages
                    ];

        return Response::json($response);

    }

    public function getEditvendormodelfeature($id) {

        $feature = VendorModelFeature::find($id);

        return $this->setView('vendormodelfeature.edit', [ 
                                                            'record' => $feature, 
                                                            'ft_types' => $this->ft_types, 
                                                            'data_types' => $this->data_types, 
                                                            'assigned_by' => $this->assigned_by
                                                        ]);
    }

    public function postUpdatevendormodelfeature($id) {

        // find the feature
        $feature = VendorModelFeature::find($id);

        // capture all user input data
        $input = Input::all();

        $all_valid     = true;
        $errormessages = [];
        $child         = isset($input['child']) && is_array($input['child']) ? $input['child'] : [];
        $keys          = isset($input['keys']) && is_array($input['keys']) ? $input['keys'] : [];
        $formlabels    = [];

        if( !$feature->populate($input)->isValid('update', $id) ) {
            $all_valid = false;
            $errormessages = getVErrorMessages($feature->vErrors);
        }

        if(isset($input['ft_label']) && !empty($input['ft_label'])) $formlabels[] = $input['ft_label'];

        foreach ($child as $k => $c) {
            if(isset($c['ft_label']) && !empty($c['ft_label'])) {

                // validating unique labels in form
                if(in_array($c['ft_label'], $formlabels)) {
                    $errormessages['child[' . $k . '][ft_label]'] = 'The Name has already been taken.';
                    $all_valid = false;
                    continue;
                }
                else $formlabels[] = $c['ft_label'];

                $object = VendorModelFeature::findOrNew($keys[$k]);
                if( !$object->populate($c)->isValid('child', $keys[$k]) ) {
                    $all_valid = false;
                    $emsgs = getVErrorMessages($object->vErrors);
                    foreach($emsgs as $f => $emsg) {
                        $errormessages['child[' . $k . ']['.$f.']'] = $emsg;
                    }
                }
            }
        }


        if($all_valid) {

            if($feature->updatefeature($input)) {

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

        $response = [
                        'status'  => 'verror',
                        'payload' => $errormessages
                    ];

        return Response::json($response);
    }

    public function getDestroyvendormodelfeature($id) {
        // fetch and delete the record
        VendorModelFeature::destroy($id);
        Session::flash('flash-done', 'Record deleted successfully.');
        return Redirect::route('masterdata.vendormodelfeature');
    }

	/////////////  CARRIER FEATURE  ///////////////

    public function anyCarriermodelfeature() {
        $params = array();
        $page = Input::get('page', 1);
        $clr  = Input::get('btnClear', false);
        $srh  = Input::get('btnSearch', false);
        $srt = [ 'srchOBy' => 'ft_label', 'srchOTp' => 'asc' ];

        if($srh) $params = Input::all();
        else if($clr) {
            Session::forget('PARAMS_CARRIERMODELFEATURESEARCH');
            $params = array();
        }
        else $params = Session::get('PARAMS_CARRIERMODELFEATURESEARCH', array());

        // merging defaut sorting values
        $params = array_merge($srt, $params);

        Session::put('PARAMS_CARRIERMODELFEATURESEARCH', $params);

        $records = CarrierModelFeature::search($page, $this->ppg, $params);

        return $this->setView('carriermodelfeature.index', ['params' => $params, 'records' => $records ]);
    }


    public function getNewchildmouldcarriermodelfeature() {
        $childKount = Input::get('ck', '0');
        return $this->setView('carriermodelfeature._newchildmould', [ 
                                                                        'ck' => $childKount, 
                                                                        'ft_types' => $this->ft_types, 
                                                                        'data_types' => $this->data_types, 
                                                                        'assigned_by' => $this->assigned_by
                                                                    ]);
    }


    public function getCreatecarriermodelfeature() {
        $feature = new CarrierModelFeature();
        $feature->is_active     = 'Yes';
        $feature->ft_unique     = 'Yes';
        $feature->ft_data_type  = 'Text';
        $feature->ft_type       = 'Text-box';
        $feature->ft_disp_order = CarrierModelFeature::where('ft_level', '1')->max('ft_disp_order') + 1;

        return $this->setView('carriermodelfeature.create', [ 
                                                                'record' => $feature, 
                                                                'ft_types' => $this->ft_types, 
                                                                'data_types' => $this->data_types,
                                                                'assigned_by' => $this->assigned_by
                                                            ]);
    }

    public function postStorecarriermodelfeature() {

        // capture all user input data
        $input = Input::all();

        $feature = new CarrierModelFeature();

        $all_valid     = true;
        $errormessages = [];
        $child         = isset($input['child']) && is_array($input['child']) ? $input['child'] : [];
        $formlabels    = [];

        if( !$feature->populate($input)->isValid('create', 0) ) {
            $all_valid = false;
            $errormessages = getVErrorMessages($feature->vErrors);
        }

        if(isset($input['ft_label']) && !empty($input['ft_label'])) $formlabels[] = $input['ft_label'];

        foreach ($child as $k => $c) {
            if(isset($c['ft_label']) && !empty($c['ft_label'])) {

                // validating unique labels in form
                if(in_array($c['ft_label'], $formlabels)) {
                    $errormessages['child[' . $k . '][ft_label]'] = 'The Name has already been taken.';
                    $all_valid = false;
                    continue;
                }
                else $formlabels[] = $c['ft_label'];

                $object = new CarrierModelFeature();
                if( !$object->populate($c)->isValid('child', 0) ) {
                    $all_valid = false;
                    $emsgs = getVErrorMessages($object->vErrors);
                    foreach($emsgs as $f => $emsg) {
                        $errormessages['child[' . $k . ']['.$f.']'] = $emsg;
                    }
                }
            }
        }


        if($all_valid) {

            if($feature->savefeature($input)) {

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

        $response = [
                        'status'  => 'verror',
                        'payload' => $errormessages
                    ];

        return Response::json($response);

    }


    public function getEditcarriermodelfeature($id) {

        $feature = CarrierModelFeature::find($id);

        return $this->setView('carriermodelfeature.edit', [ 
                                                            'record' => $feature, 
                                                            'ft_types' => $this->ft_types, 
                                                            'data_types' => $this->data_types, 
                                                            'assigned_by' => $this->assigned_by
                                                        ]);
    }

    public function postUpdatecarriermodelfeature($id) {

        // find the feature
        $feature = CarrierModelFeature::find($id);

        // capture all user input data
        $input = Input::all();

        $all_valid     = true;
        $errormessages = [];
        $child         = isset($input['child']) && is_array($input['child']) ? $input['child'] : [];
        $keys          = isset($input['keys']) && is_array($input['keys']) ? $input['keys'] : [];
        $formlabels    = [];

        if( !$feature->populate($input)->isValid('update', $id) ) {
            $all_valid = false;
            $errormessages = getVErrorMessages($feature->vErrors);
        }

        if(isset($input['ft_label']) && !empty($input['ft_label'])) $formlabels[] = $input['ft_label'];

        foreach ($child as $k => $c) {
            if(isset($c['ft_label']) && !empty($c['ft_label'])) {

                // validating unique labels in form
                if(in_array($c['ft_label'], $formlabels)) {
                    $errormessages['child[' . $k . '][ft_label]'] = 'The Name has already been taken.';
                    $all_valid = false;
                    continue;
                }
                else $formlabels[] = $c['ft_label'];

                $object = CarrierModelFeature::findOrNew($keys[$k]);
                if( !$object->populate($c)->isValid('child', $keys[$k]) ) {
                    $all_valid = false;
                    $emsgs = getVErrorMessages($object->vErrors);
                    foreach($emsgs as $f => $emsg) {
                        $errormessages['child[' . $k . ']['.$f.']'] = $emsg;
                    }
                }
            }
        }


        if($all_valid) {

            if($feature->updatefeature($input)) {

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

        $response = [
                        'status'  => 'verror',
                        'payload' => $errormessages
                    ];

        return Response::json($response);
    }


    public function getDestroycarriermodelfeature($id) {
        // fetch and delete the record
        CarrierModelFeature::destroy($id);
        Session::flash('flash-done', 'Record deleted successfully.');
        return Redirect::route('masterdata.carriermodelfeature');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

}

