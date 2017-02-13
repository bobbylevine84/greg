<?php

Use Carbon\Carbon as Carbon;

class ReportController extends BaseController {

	protected $report;
	protected $statuses;

	public function __construct(Report $report) {

		parent::__construct();

		$this->beforeFilter(function() {
			$app = App::make('myApp');
			if(!$app->isCustAdmin)
				return Redirect::to('error')
						->withErrors([
										'errorcode'  => '500',
										'errormsg'   => 'Oops! You have do not have access to the resource.',
										'suggestion' => 'Please try a different page.'
									]);
		}, array('only' => ['anyGroups', 'anyUser']));

		$this->report = $report;
		//$this->ppg 	   = 20;
		$this->statuses = [
							'Available' => 'Available',
							'Staged' => 'Staged',
							'Deployed' => 'Deployed',
						];
		$this->menu = 'report';// for selecting sidemenu
	}

	public function anyIndex() { return Redirect::route('report.radioinventory'); }

    public function anyRadioinventory() {
		$app = App::make('myApp');

		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'tbl_vendor.vendor_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_RPTRADIOINVENTORYSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_RPTRADIOINVENTORYSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_RPTRADIOINVENTORYSEARCH', $params);

        $reports = $this->report->searchRadioInventory($pgn, $this->ppg, $params);

        // $vendors = $this->administrator->vendors()->isActive()->get()->lists('vendor_name', '_id');

        // $models = [];
        // if( count($vendors) > 0 ) $models = VendorModel::whereIn('vendor_id', array_keys($vendors))
        // 												->isActive()
        // 												->get()
        // 												->lists('model_name', '_id');


        $administrator = getTheBoss();

        // fetching vendors and models
        $vendors = $models = [];// container for vendors & vendor models
		if(!$app->isCustAdmin) {
			$appUser = USER::find($app->uid);// get logged in user

			$uts = $appUser->templates();// get all templates for logged in user

			// loop for each template and get the vendor id out of it
			if(count($uts)>0) {
				foreach($uts as $t) {
					$vendors[$t->vendor_id] = $t->vendor->vendor_name;
					$models[$t->vendor_model_id] = $t->vendormodel->model_name;
				}
			}
		}
		else {
	        $vendors = $administrator->vendors()->isActive()->get()->lists('vendor_name', '_id');
	        $models  = $administrator->vendormodels()->isActive()->get()->lists('model_name', '_id');
		}

        return $this->setView('report.radioinventory', [
        											'params' => $params,
        											'records' => $reports,
        											'vendors' => $vendors,
        											'models' => $models,
        											'statuses' => $this->statuses,
        										]);
    }

    public function anyCarrierinventory() {
		$app = App::make('myApp');

		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'tbl_carrier.carrier_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_RPTCARRIERINVENTORYSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_RPTCARRIERINVENTORYSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_RPTCARRIERINVENTORYSEARCH', $params);

        $carrierinventorys = $this->report->searchCarrierInv($pgn, $this->ppg, $params);

        // $carriers = $this->administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');

        // $models = [];
        // if( count($carriers) > 0 ) $models = CarrierModel::whereIn('carrier_id', array_keys($carriers))
        // 												->isActive()
        // 												->get()
        // 												->lists('model_name', '_id');

        $administrator = getTheBoss();

        // fetching carriers
        $carriers = $models = [];// container for carriers and models
		if(!$app->isCustAdmin) {
			$appUser = USER::find($app->uid);// get logged in user

			$uts = $appUser->templates();// get all templates for logged in user

			// loop for each template and get the carrier id out of it
			if(count($uts)>0) {
				foreach($uts as $t) {
					if($t->carriermodel) {
						$carriers[$t->carrier_id] = $t->carrier->carrier_name;
						$models[$t->carrier_model_id] = $t->carriermodel->model_name;
					}
				}
			}
		}
		else {
	        $carriers = $this->administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
	        $models   = $this->administrator->carriermodels()->isActive()->get()->lists('model_name', '_id');
		}

        return $this->setView('report.carrierinventory', [
        											'params' => $params,
        											'records' => $carrierinventorys,
        											'carriers' => $carriers,
        											'models' => $models,
        											'statuses' => $this->statuses,
        										]);
    }

    public function anyGroups() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'group_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_RPTGROUPSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_RPTGROUPSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_RPTGROUPSEARCH', $params);

        $groupss = $this->report->searchGroups($pgn, $this->ppg, $params);

        return $this->setView('report.groups', [ 'params' => $params, 'records' => $groupss ]);
    }

    public function anyUser() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'user_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_RPTUSERSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_RPTUSERSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_RPTUSERSEARCH', $params);

        $users = $this->report->searchUser($pgn, $this->ppg, $params);

        return $this->setView('report.user', [ 'params' => $params, 'records' => $users ]);
    }

    public function anyDeploymentscomplated() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'tbl_template.tmpl_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_RPTDEPSCOMPL');
			$params = array();
		}
		else $params = Session::get('PARAMS_RPTDEPSCOMPL', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_RPTDEPSCOMPL', $params);

        $provisions = $this->report->deploymentscomplete($pgn, $this->ppg, $params);

        return $this->setView('report.deploymentscomplete', [ 'params' => $params, 'records' => $provisions ]);
    }

    public function getDeploymentdetails($pid=0) {

    	$records = [];

    	$deployments = ProvisionRadioItem::with('provisionuser')
    										->with('template.vendor')
    										->with('template.vendormodel')
    										->where('provision_id', $pid)
    										->where('status', 'Deployed')
    										->get();
    	if($deployments) {

    		// getting deployment ips
			$sql  = " select radio_item_id, GROUP_CONCAT(DISTINCT INET_NTOA(ft_fld_value) ORDER BY ft_fld_value SEPARATOR ', ') as ips ";
			$sql .= " from tbl_provision_radio_item_feature ";
			$sql .= " where provision_id = " . $pid;
			$sql .= " and status = 'Deployed' ";
			$sql .= " and ft_is_ip = 'Yes' ";
			$sql .= " group by radio_item_id ";
			$sql .= " order by radio_item_id ";
			$resips = DB::select($sql);

			$iparr = $tmpl_arr = [];
			foreach ($resips as $rip) {
				$iparr[$rip->radio_item_id] = $rip->ips;
			}

    		foreach ($deployments as $d) {
    			$dar = $d->toArray();

				$data = new stdClass();
				$data->user   = array_get($dar, 'provisionuser.user_name');
				$data->vendor = array_get($dar, 'template.vendor.vendor_name');
				$data->model  = array_get($dar, 'template.vendormodel.model_name');
				$data->dt 	  = $d->deployed_at;
				$data->serial = $d->sku;
				$data->depips = array_key_exists($d->_id, $iparr) ? $iparr[$d->_id] : null;

    			$records[] = $data;
    		}
    	}


    	return $this->setView('report._deploymentdetails', [ 'pid' => $pid, 'records' => $records ]);
    }

	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_RPTRADIOINVENTORYSEARCH');
    	Session::forget('PARAMS_RPTCARRIERINVENTORYSEARCH');
    	Session::forget('PARAMS_RPTGROUPSEARCH');
    	Session::forget('PARAMS_RPTUSERSEARCH');
    	echo 'all params flushed...';
    }

}
