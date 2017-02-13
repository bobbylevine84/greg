<?php

class AppSettingController extends BaseController {


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

		//$this->ppg 	   = 10;
		$this->menu = '';// for selecting sidemenu
	}

    public function anyIndex() {

    	//$tmp = new CUSTOMER();
    	//$tmp->getRUK();

		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_APPSETTINGSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_APPSETTINGSEARCH', array());

		Session::put('PARAMS_APPSETTINGSEARCH', $params);

        $appsettings = AppSetting::search($pgn, $this->ppg, $params);

        return $this->setView('setting.index', ['params' => $params, 'records' => $appsettings, 'pgn' => $pgn]);
    }


    public function postUpdate($pgn=1) {

    	$s_keys = Input::get('set_key');
    	$s_vals = Input::get('set_value');

    	foreach ($s_keys as $k => $key) {
    		if(isset($s_vals[$k])) {
    			$set = AppSetting::find($key);
    			$set->set_value = $s_vals[$k];
    			$set->save();
    		}
    	}

		// generate success message
		Session::flash('flash-done', 'Record saved successfully.');
		return Redirect::to('appsetting/index?page='.$pgn);
    }

	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_APPSETTINGSEARCH');
    	echo 'all params flushed...';
    }

}
