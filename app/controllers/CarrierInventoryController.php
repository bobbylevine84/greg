<?php

class CarrierInventoryController extends BaseController {

	protected $carrierinventory;
	protected $statuses;

	public function __construct(CarrierInventory $carrierinventory) {

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

		$this->carrierinventory = $carrierinventory;
		//$this->ppg 	   = 20;
		$this->statuses = [
							'Available' => 'Available',
							'Staged' => 'Staged',
							'Deployed' => 'Deployed',
						];
		$this->menu = 'carrierinv';// for selecting sidemenu
	}

    public function anyIndex() {
		$app = App::make('myApp');

		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'carrier_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_CARRIERINVENTORYSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_CARRIERINVENTORYSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_CARRIERINVENTORYSEARCH', $params);

        $carrierinventorys = $this->carrierinventory->search($pgn, $this->ppg, $params);

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

        return $this->setView('carrierinventory.index', [
        											'params' => $params,
        											'records' => $carrierinventorys,
        											'carriers' => $carriers,
        											'models' => $models,
        											'statuses' => $this->statuses,
        										]);
    }

    public function getCarriermodels() {
    	$vid = Input::get('vid', '0');
    	//$models = CarrierModel::isActive()->where('carrier_id', $vid)->get()->lists('model_name', '_id');
    	$models = $this->administrator->carriermodels()->isActive()->where('carrier_id', $vid)->get()->lists('model_name', '_id');
        $models = [null => 'Select Model'] + $models;

        return $this->setView('carrierinventory.carriermodels', [ 'models' => $models, ]);
    }

    public function getCreate() {
		$carrierinventory = new CarrierInventory();

        $carriers = $this->administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
        $carriers = [null => 'Select Carrier'] + $carriers;

        //$models  = CarrierModel::all()->lists('model_name', '_id');
        $models  = [null => 'Select Model'];// + $models;

        return $this->setView('carrierinventory.create', [ 'record' => $carrierinventory, 'carriers' => $carriers, 'models' => $models, ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();

    	// fill and save the data after auto validation
    	if( !$this->carrierinventory->populate($input)->isValid('create', 0) ) {
    	//if( !$this->carrierinventory->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->carrierinventory->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->carrierinventory->save()) {

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

		$carrierinventory = CarrierInventory::find($id);

        $carriers = $this->administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
        $carriers = [null => 'Select Carrier'] + $carriers;

        $models  = CarrierModel::isActive()->where('carrier_id', $carrierinventory->carrier_id)->get()->lists('model_name', '_id');
        $models  = [null => 'Select Model'] + $models;

        return $this->setView('carrierinventory.edit', [
        											'record' => $carrierinventory,
        											'carriers' => $carriers,
        											'models' => $models,
        										]);
    }

    public function postUpdate($id) {

	    // find the carrierinventory
	    $this->carrierinventory = CarrierInventory::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->carrierinventory->populate($input)->isValid('update', $id) ) {
    	//if( !$this->carrierinventory->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->carrierinventory->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->carrierinventory->save()) {

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

    public function getImportfromfile() {

		$carrierinventory = new CarrierInventory();
		$carrierinventory->has_header = '0';

        $carriers = $this->administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
        $carriers = [null => 'Select Carrier'] + $carriers;

		$vid = Input::old('carrier_id', '0');
		$models  = CarrierModel::isActive()->where('carrier_id', $vid)->get()->lists('model_name', '_id');
		$models  = [null => 'Select Model'] + $models;

        return $this->setView('carrierinventory.import', [ 'record' => $carrierinventory, 'carriers' => $carriers, 'models' => $models, ]);
    }

    public function postSaveimport() {

    	// capture all user input data
    	$input = Input::all();

    	$carrierinventory = new CarrierInventory();

    	// validate input
    	if( !$carrierinventory->isValidImport($input) ) {
	        return Redirect::back()
	            ->withInput()
	            ->withErrors($carrierinventory->vErrors);
    	}

		// storing the file temporarily
		$upfile = Input::file('import_file');
		$filename = time() . '_' . mt_rand() . '.' . $upfile->getClientOriginalExtension();
		$uploadpath = public_path() . '/uploads/tmpfiles';
		$upfile->move($uploadpath, $filename);
		$file = $uploadpath . '/' . $filename;

		$data = [];

		// validating each data from file
		if(File::exists($file)) {

			$line = [];
			$line['carrier_id'] = Input::get('carrier_id', '0');
			$line['model_id']   = Input::get('model_id', '0');
			$hdr = Input::get('has_header', '0');
			$line_no = 0;
			$emsg = '';

			$handle = @fopen($file, "r");
			if ($handle) {
				
				// skipping first line if header present
				if($hdr) {
					$buffer = @fgets($handle, 4096);
					$line_no++;
				}

				// looping for all lines
			    while (($buffer = fgets($handle, 4096)) !== false) {
			    	$line_no++;
					$buffer = str_replace(["\r\n", "\n\r", "\r", "\n"], '', $buffer);
					$line['sku'] = $buffer;
			    	
			    	$object = new CarrierInventory();
			    	if(!$object->populate($line)->isValid('create', 0)) {

						$errormessages = getVErrorMessages($object->vErrors);

						reset($errormessages);
						$emsg = current($errormessages);

			    		break;
			    	}
			    	$data[] = $object;
			    }
			    if (!feof($handle)) {
				    fclose($handle);
					File::delete($file);

				    $showmsg = '';
				    if(empty($emsg)) $showmsg = 'Error: failed to read from file.';
				    else $showmsg = 'Error: "' . $emsg . '" at line ' . $line_no . '. Import aborted.';
			        //echo "Error: unexpected fgets() fail\n";

					Session::flash('flash-error', $showmsg);
			        return Redirect::back()
			            ->withInput()
						->withErrors([ 'import_file' => $showmsg ]);
			    }
			    fclose($handle);
			}
			File::delete($file);
		}

		// save and generate success message
		if($carrierinventory->saveimport($data)) {
			Session::flash('flash-done', 'File imported successfully.');
			return Redirect::route('carrierinventory.index');
		}

		Session::flash('flash-error', 'Could not import file.');
        return Redirect::back()
            ->withInput();

    }

    public function getDestroy($id) {
    	// fetch and delete the record
		CarrierInventory::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::route('carrierinventory.index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_CARRIERINVENTORYSEARCH');
    	echo 'all params flushed...';
    }

}
