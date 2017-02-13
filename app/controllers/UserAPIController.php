<?php

class UserAPIController extends BaseController {

	function __construct() {
		parent::__construct();
	}

	protected function autheticateRequest() {
		$unm = Input::get('username', '');
		$psd = Input::get('password', '');
		$ruk = Input::get('ruk', '');

		if (Auth::user()->attempt([ 'username' => $unm, 'password' => $psd, 'ruk' => $ruk, 'is_active' => 'Yes' ])) {
			$us = Auth::user()->get();
			return USER::find($us->_id);
		}

		return FALSE;

		//return USER::find(1);
	}

	public function anyTemplates() {

		// check if the request is authentic
		$user = $this->autheticateRequest();

		// check authentication success
		if($user === FALSE) {
			$response = [
							'status'  => 'error',
							'payload' => 'Unauthorized'
						];

			return Response::json($response);
		}

		// get the user group ids of authenticated user
		$groups = $user->groups()->isActive()->get()->lists('_id');

		// get the templates of the groups
		$templates = Templates::with('vendor', 'vendormodel', 'carrier', 'carriermodel')
								// ->whereHas('provisions', function($q) {
								// 	$q->isActive();
								// })
								->whereHas('provisioneditems', function($q) {
									$q->where('status', 'Staged');
								})
								->whereHas('groups', function($q) use($groups) {
									$q->whereIn('group_id', $groups);
								})->isActive()->get();//

		$ret = [];
		foreach($templates as $k => $t) {
			$t = $t->toArray();
			$ret[$k] = [
						'tmpl_id' => $t['_id'],
						'tmpl_name' => $t['tmpl_name'],
						'vendor_id' => array_get($t, 'vendor._id'),
						'vendor_name' => array_get($t, 'vendor.vendor_name'),
						'vendor_model_name' => array_get($t, 'vendormodel.model_name'),
						'vendor_need_serial' => $t['need_vendor_sku'], 
						'carrier_id' => array_get($t, 'carrier._id'),
						'carrier_name' => array_get($t, 'carrier.carrier_name'),
						'carrier_model_name' => array_get($t, 'carriermodel.model_name'),
					];

			$ret[$k]['carrier_need_serial'] = !empty($ret[$k]['carrier_id']) ? $t['need_carrier_sku'] : 'No';
		}

		//$templates = $user->templates([ '_id', 'tmpl_name' ])->toArray();

		$response = [
						'status'  => 'success',
						'payload' => $ret
					];

		return Response::json($response);
	}

	public function anyProvisions() {

		$return = [];

		// check if the request is authentic
		$user = $this->autheticateRequest();

		// check authentication success
		if($user === FALSE) {
			$response = [
							'status'  => 'error',
							'payload' => 'Unauthorized'
						];

			return Response::json($response);
		}

		$tmpl = Input::get('tmpl', '0');

		$avltmpls = $user->templates()->lists('_id');

		// checking if this is a valid template for the user and the user has access to it
		if(!in_array($tmpl, $avltmpls)) {
			$response = [
							'status'  => 'error',
							'payload' => 'Invalid Template'
						];

			return Response::json($response);
		}

		// here we first fetch the selected template with its 
		// vendor, vendor model, vendor model features, 
		// carrier, carrier model and carrier model features
		$template = Templates::with('vendor', 'vendormodel', 'carrier', 'carriermodel', 'vendormodelfeatures', 'carriermodelfeatures')
								->where('_id', $tmpl)
								->first();

		// checking if this template has an active provision
		$prov_count = Provision::isActive()->where('tmpl_id', $tmpl)->where('status', 'Staged')->count();
		if($prov_count <= 0) {
			$response = [
							'status'  => 'error',
							'payload' => 'No Provisions found'
						];

			return Response::json($response);
		}

		// for each of the features, if the value is to be set by radio admin
		// then we also fetch the last used value for that feature for that template
		if($template) {
			$tmplArr = $template->toArray();
			$t = $tmplArr;

			$return = [
						'tmpl_id' => $t['_id'],
						'tmpl_name' => $t['tmpl_name'],
						'vendor_id' => array_get($t, 'vendor._id'),
						'vendor_name' => array_get($t, 'vendor.vendor_name'),
						'vendor_model_name' => array_get($t, 'vendormodel.model_name'),
						'vendor_need_serial' => $t['need_vendor_sku'], 
						'carrier_id' => array_get($t, 'carrier._id'),
						'carrier_name' => array_get($t, 'carrier.carrier_name'),
						'carrier_model_name' => array_get($t, 'carriermodel.model_name'), 
					];

			$return['carrier_need_serial'] = !empty($return['carrier_id']) ? $t['need_carrier_sku'] : 'No';

			// fetch and parse vendor model features
			$vmf = [];
			foreach($t['vendormodelfeatures'] as $mf) {
				
				$mfv = [];

				if($mf['ft_type'] == 'Label') continue;// skipping if its a label

				// fetching the feature value from template
				$fv = $this->getMFValue($mf, 'Radio');

				if(is_array($fv)) $mfv = $fv;
				else $mfv[0] = $fv;

				// if value to be assigned by radio admin the fetching the last used value
				// for the current feature and template
				if($mf['ft_value_assigned_by'] == 'Radio Admin') $mfv['Last_Value'] = $this->getMFLastUsedVal($mf, 'Radio');

				// $mfv['Last_Value'] = $this->getMFLastUsedVal($mf, 'Radio');

				$sln = $this->getSendableFtNameFromLabel($mf['ft_label']);
				$vmf[$sln] = $mfv;
			}
			$return['vendormodelfeatures'] = $vmf;

			// fetch and parse carrier model features
			if(isset($return['carrier_id']) && !empty($return['carrier_id'])) {

				$cmf = [];
				foreach($t['carriermodelfeatures'] as $mf) {
					
					$mfv = [];

					if($mf['ft_type'] == 'Label') continue;// skipping if its a label

					// fetching the feature value from template
					$fv = $this->getMFValue($mf, 'Carrier');

					if(is_array($fv)) $mfv = $fv;
					else $mfv[0] = $fv;

					// if value to be assigned by radio admin then fetching the last used value
					// for the current feature and template
					if($mf['ft_value_assigned_by'] == 'Radio Admin') $mfv['Last_Value'] = $this->getMFLastUsedVal($mf, 'Carrier');

					$sln = $this->getSendableFtNameFromLabel($mf['ft_label']);
					$cmf[$sln] = $mfv;
				}
				$return['carriermodelfeatures'] = $cmf;

				// // get all radio serails staged against this template
				// $cskus = ProvisionRadioItemCarrierItem::whereIn('provision_id', $pids)
				// 										->where('status', 'Staged')
				// 										->get()->lists('sku');

				// $return['carriermodelserials'] = implode(',', $cskus);
			}

			// get all active provisions for the template
			$pids = Provision::isActive()->where('tmpl_id', $tmpl)->get()->lists('_id');

			// get all radios staged against this template
			$ritems = ProvisionRadioItem::whereIn('provision_id', $pids)
										->where('status', 'Staged')
										->get();

			// looping for each radio item
			$riskus = [];
			foreach($ritems as $k => $ri) {
				$riskus[$k] = [
								'rpid' => $ri->_id, 
								'radio_serial' => $ri->sku, 
							];

				// getting carrier skus for the radio item
				$carrieritems = $ri->carrieritems()->where('status', 'Staged')->get()->toArray();

				if(count($carrieritems)>0) {
					foreach($ri->carrieritems as $ck => $ci) {
						$riskus[$k]['carrier'][$ck]['cpid'] = $ci['_id'];
						$riskus[$k]['carrier'][$ck]['serial'] = $ci['sku'];
					}
				}

			}

			$return['vendormodelserials'] = $riskus;//implode(',', $vskus);
		}

		// pr($return, 1);

		$response = [
						'status'  => 'success',
						'payload' => $return
					];

		return Response::json($response);
	}

	public function anyUpdate() {

		// check if the request is authentic
		$user = $this->autheticateRequest();

		// check authentication success
		if($user === FALSE) {
			$response = [
							'status'  => 'error',
							'payload' => 'Unauthorized'
						];

			return Response::json($response);
		}

		$input = Input::all();

		$prov = new Provision();

		$upd = $prov->updatedeployment($input, $user->_id);

		if($upd === TRUE) {

			$response = [
							'status'  => 'success',
							'payload' => ''
						];

			return Response::json($response);
		}

		$response = [
						'status'  => 'error',
						'payload' => $upd, //'Could not update Provision.'
					];

		return Response::json($response);

	}


	// HELPER FUNCTIONS
	protected function getSendableFtNameFromLabel($lbl='') {

        $lbl = str_replace(" ", "_", $lbl);
        return $lbl;
	}

	protected function getFeatureNameFromSendable($txt='') {

        $txt = str_replace("_", " ", $txt);
        return $txt;
	}

    protected function getMFValue($mf=[], $type='Radio') {

      $ret = '';// setting a default return value

      if(count($mf)<=0) return $ret;

      // checking field type of feature and then its data type
      // Text-box/Text-area/Drop-down/Range/IP/IP Range
      // if incrementing then get the next value
      // if numeric then get value from numeric field and assign the same
      // if text then get the value from the text field and assign the same
      switch($mf['ft_type']) {

        // for Text-area
        case 'Text-area':
          $ret = $mf['txtvalue'];
          break;

        // for IP
        case 'IP':
          $ret = $mf['decvalue'];
          break;

        // for IP Range
        case 'IP Range':
          $ret = [
          			'Start' => $mf['decvalue'],
          			'End' => $mf['decvalue2'],
          		];

          break;

        // for Range
        case 'Range':

          $ret = [
          			'Start' => $mf['ft_data_type'] == 'Text' ? $mf['varvalue'] : number_format($mf['decvalue'], $mf['ft_decs'], '.', ''), 
          			'End' => $mf['ft_data_type'] == 'Text' ? $mf['varvalue2'] : number_format($mf['decvalue2'], $mf['ft_decs'], '.', '')
          		];

          break;

        // for Text-box
        case 'Text-box':
        // for Drop-down
        case 'Drop-down':
        default:
          $ret = $mf['ft_data_type'] == 'Text' ? $mf['varvalue'] : number_format($mf['decvalue'], $mf['ft_decs'], '.', '');
          break;
      }

    //   // removing decimal parts if numeric value
    //   if(is_array($ret)) {
    //   	foreach ($ret as $k => $v) {
    //   		if(is_numeric($v)) $ret[$k] = trimToInteger($v);
    //   	}
    //   }
    //   else {
  		// if(is_numeric($ret)) $ret = trimToInteger($ret);
    //   }

      return $ret;
    }

    protected function getMFLastUsedVal($mf, $type='Radio' ) {

      $lastVal = $start = '';
      $vals = [];

      // getting max values
      if($type=='Radio') {
        $vals = ProvisionRadioItemFeature::where('tmpl_id', $mf['tmpl_id'])
                                             ->where('ft_fld_name', $mf['ft_fld_name'])
                                             ->where('status', '<>', 'Released')
                                             ->get()
                                             ->lists('ft_fld_value');
      }
      else if($type=='Carrier') {
        $vals = ProvisionRadioItemCarrierItemFeature::where('tmpl_id', $mf['tmpl_id'])
                                             ->where('ft_fld_name', $mf['ft_fld_name'])
                                             ->where('status', '<>', 'Released')
                                             ->get()
                                             ->lists('ft_fld_value');
      }

      // getting start and end limits
      // checking for Range
      if($mf['ft_type'] == 'Range') {
        $start = $mf['ft_data_type'] == 'Text' ? ord($mf['varvalue']) : number_format($mf['decvalue'], $mf['ft_decs'], '.', '');
        $end   = $mf['ft_data_type'] == 'Text' ? ord($mf['varvalue2']) : number_format($mf['decvalue2'], $mf['ft_decs'], '.', '');
      }

      // checking for IP Range
      if($mf['ft_type'] == 'IP Range') {
        $start = sprintf("%u", ip2long($mf['decvalue']));
        $end   = sprintf("%u", ip2long($mf['decvalue2']));
        array_walk($vals, 'iptono');
      }

      // checking for IP
      if($mf['ft_type'] == 'IP') {
        $start = sprintf("%u", ip2long($mf['decvalue']));
        array_walk($vals, 'iptono');
      }

      // if none of the above type
      // then select a default start value
      if(empty($start)) {
        $start = $mf['ft_data_type'] == 'Text' ? 65 : 1;
      }


      $maxval = @max($vals);

// echo 'First Maxval ';
// pr($maxval);

      if($maxval && !empty($maxval)) {
        // // checking for IP type
        // if($mf['ft_type'] == 'IP' || $mf['ft_type'] == 'IP Range') $maxval = sprintf("%u", ip2long($maxval));

        // // checking for Text type
        // if($mf['ft_data_type'] == 'Text') $maxval = ord($maxval);
      }
      else $maxval = $start;

      $lastVal = $maxval;

      // returning next value
      if($mf['ft_type'] == 'IP' || $mf['ft_type'] == 'IP Range') $lastVal = long2ip($lastVal);
      else if($mf['ft_type'] == 'Range' && $mf['ft_data_type'] == 'Text') $lastVal = chr($lastVal);
      else if(is_numeric($lastVal)) $lastVal = number_format($lastVal, $mf['ft_decs'], '.', '');

      // removing decimal parts if numeric value
	  // if(is_numeric($lastVal)) $lastVal = trimToInteger($lastVal);

      return $lastVal;
    }

	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

}
