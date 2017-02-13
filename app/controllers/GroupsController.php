<?php

class GroupsController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $groups;

	public function __construct(Groups $groups) {

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
		});

		$this->groups = $groups;
		//$this->ppg 	   = 20;
		$this->menu = 'group';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'group_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_GROUPSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_GROUPSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_GROUPSEARCH', $params);

        $groupss = $this->groups->search($pgn, $this->ppg, $params);

        return $this->setView('groups.index', [ 'params' => $params, 'records' => $groupss ]);
    }


    public function getCreate() {
		$groups = new Groups();
		$groups->is_active = 'Yes';
		$groups->is_admin  = 'No';

        return $this->setView('groups.create', [ 'record' => $groups ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	if( !$this->groups->populate($input)->isValid($input, 'create', 0) ) {
    	//if( !$this->groups->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->groups->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->groups->save()) {

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

		$groups = Groups::find($id);

        return $this->setView('groups.edit', [ 'record' => $groups ]);
    }

    public function postUpdate($id) {

	    // find the groups
	    $this->groups = Groups::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->groups->populate($input)->isValid('update', $id) ) {
    	//if( !$this->groups->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->groups->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->groups->save()) {

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
		Groups::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::route('groups.index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_GROUPSEARCH');
    	echo 'all params flushed...';
    }

}
