<?php

class UserController extends BaseController {

	//private $ppg;// items shown per page when paginated
	protected $user;

	public function __construct(USER $user) {

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
		}, array('except' => ['getUseraccount', 'getChangepassword', 'postUpdatepassword']));

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

		$this->user = $user;
		//$this->ppg 	   = 20;
		$this->menu = 'user';// for selecting sidemenu
	}

    public function anyIndex() {
		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'tbl_user.user_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_USERSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_USERSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_USERSEARCH', $params);

        $users = $this->user->search($pgn, $this->ppg, $params);

        return $this->setView('user.index', [ 'params' => $params, 'records' => $users ]);
    }


    public function getCreate() {
		$user = new USER();
		$user->is_active = 'Yes';

		$app = App::make('myApp');
		$groups = Groups::isActive()->where('cust_id', $app->custAdminID)->get()->lists('group_name', '_id');

        return $this->setView('user.create', [ 'record' => $user, 'groups' => $groups ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	//if( !$this->user->populate($input)->isValid($input, 'create', 0) ) {
    	if( !$this->user->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->user->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->user->saveuser($input, 'create')) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
							//'payload' => [ 'frm-success' => 'Record saved successfully.' ]
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

		$user = USER::find($id);

		$app = App::make('myApp');
		$groups = Groups::isActive()->where('cust_id', $app->custAdminID)->get()->lists('group_name', '_id');
		//$groups = Groups::isActive()->get()->lists('group_name', '_id');

		$selgroups = $user->groups->lists('_id');

        return $this->setView('user.edit', [ 'record' => $user, 'groups' => $groups, 'selgroups' => $selgroups ]);
    }

    public function postUpdate($id) {

	    // find the user
	    $this->user = USER::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	//if( !$this->user->populate($input)->isValid('update', $id) ) {
    	if( !$this->user->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->user->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->user->saveuser($input, 'update')) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
							//'payload' => [ 'frm-success' => 'Record saved successfully.' ]
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

    public function getMyaccount() {

		$app = App::make('myApp');
		$user = USER::find($app->uid);

        return $this->setView('user.myaccount', [ 'record' => $user ]);
    }

    public function postUpdatemyaccount() {

	    // find the user
		$app = App::make('myApp');
		$this->user = USER::find($app->uid);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	//if( !$this->user->populate($input)->isValid('updateaccount', $app->uid) ) {
    	if( !$this->user->isValid($input, 'updateaccount', $app->uid) ) {

			$errormessages = getVErrorMessages($this->user->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		$this->user->populate($input);
		// save and generate success message
		if($this->user->save()) {

			$response = [
							'status'  => 'success',
							'payload' => [ 'frm-success' => 'Record saved successfully.' ]
						];

			return Response::json($response);

		}

		$response = [
						'status'  => 'error',
						'payload' => [ 'frm-error' => 'Could not save record.' ]
					];

		return Response::json($response);
    }


    public function getChangepassword() {
    	$app = App::make('myApp');

		$user = USER::find($app->uid);

		$redir =  $app->isCustAdmin ? URL::route('user.myaccount') : URL::route('user.useraccount');

        return $this->setView('user.changepassword', [ 'record' => $user, 'redir' => $redir]);
    }


    public function postUpdatepassword() {
    	$app = App::make('myApp');
    	//if($app->isSU) return Redirect::to('/');

		$this->user = USER::find($app->uid);

    	// get the previous password
    	$prev_paswd = $this->user->password;

    	// capture all user input data
    	$input = Input::all();

    	$this->user->populate($input);

    	// validate the data
    	//if( !$this->user->populate($input)->isValid('updatepassword', $app->uid) ) {
    	if( !$this->user->isValid($input, 'updatepassword', $app->uid) ) {

			$errormessages = getVErrorMessages($this->user->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);

    	}
    	elseif(Hash::check($input['password'], $prev_paswd)) {
			$response = [
							'status'  => 'error',
							'payload' => [ 'frm-error' => 'Please enter a password other than your previous password.' ]
						];

			return Response::json($response);
    	}
		// save and generate success message
		elseif($this->user->save()) {

			Session::flash('flash-done', 'Record saved successfully.');

			$response = [
							'status'  => 'success',
							'payload' => '',
							//'payload' => [ 'frm-success' => 'Record saved successfully.' ]
						];

			return Response::json($response);
		}

		$response = [
						'status'  => 'error',
						'payload' => [ 'frm-error' => 'Could not save record.' ]
					];

		return Response::json($response);
    }


    public function getUseraccount() {

		$app = App::make('myApp');
		$user = USER::find($app->uid);

        return $this->setView('user.useraccount', [ 'record' => $user ]);
    }


    public function getShowaccount($id) {

		$app = App::make('myApp');
		$user = USER::find($id);
		if($user->onboarding->rep_id != $app->uid) {
			Session::flash('flash-warning', 'Sorry! The record is unavailable.');
			return Redirect::route('user.index');
		}
        return $this->setView('user.showaccount', [ 'record' => $user ]);
    }




    public function getDestroy($id) {
    	// fetch and delete the record
		USER::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::to('user/index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_USERSEARCH');
    	echo 'all params flushed...';
    }

}
