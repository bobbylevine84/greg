<?php

class RadioInventoryController extends BaseController {

	protected $radioinventory;
	protected $statuses;

	public function __construct(RadioInventory $radioinventory) {

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

		$this->radioinventory = $radioinventory;
		//$this->ppg 	   = 20;
		$this->statuses = [
							'Available' => 'Available',
							'Staged' => 'Staged',
							'Deployed' => 'Deployed',
						];
		$this->menu = 'radioinv';// for selecting sidemenu
	}

    public function anyIndex() {
		$app = App::make('myApp');

		$params = array();
		$pgn = Input::get('page', 1);
		$clr = Input::get('btnClear', false);
		$srh = Input::get('btnSearch', false);
		$srt = [ 'srchOBy' => 'vendor_name', 'srchOTp' => 'asc' ];

		if($srh) $params = Input::all();
		else if($clr) {
			Session::forget('PARAMS_RADIOINVENTORYSEARCH');
			$params = array();
		}
		else $params = Session::get('PARAMS_RADIOINVENTORYSEARCH', array());

		// merging defaut sorting values
		$params = array_merge($srt, $params);

		Session::put('PARAMS_RADIOINVENTORYSEARCH', $params);

        $radioinventorys = $this->radioinventory->search($pgn, $this->ppg, $params);

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


        return $this->setView('radioinventory.index', [
        											'params' => $params,
        											'records' => $radioinventorys,
        											'vendors' => $vendors,
        											'models' => $models,
        											'statuses' => $this->statuses,
        										]);
    }

    public function getVendormodels() {
    	$vid = Input::get('vid', '0');
    	//$models = VendorModel::isActive()->where('vendor_id', $vid)->get()->lists('model_name', '_id');
    	$models = $this->administrator->vendormodels()->isActive()->where('vendor_id', $vid)->get()->lists('model_name', '_id');
        $models = [null => 'Select Model'] + $models;

        return $this->setView('radioinventory.vendormodels', [ 'models' => $models, ]);
    }

    public function getCreate() {
		$radioinventory = new RadioInventory();

        $vendors = $this->administrator->vendors()->isActive()->get()->lists('vendor_name', '_id');
        $vendors = [null => 'Select Vendor'] + $vendors;

        //$models  = VendorModel::all()->lists('model_name', '_id');
        $models  = [null => 'Select Model'];// + $models;

        return $this->setView('radioinventory.create', [ 'record' => $radioinventory, 'vendors' => $vendors, 'models' => $models, ]);
    }

    public function postStore() {

    	// capture all user input data
    	$input = Input::all();
        
    	// fill and save the data after auto validation
    	if( !$this->radioinventory->populate($input)->isValid('create', 0) ) {
    	//if( !$this->radioinventory->isValid($input, 'create', 0) ) {

			$errormessages = getVErrorMessages($this->radioinventory->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->radioinventory->save()) {

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

		$radioinventory = RadioInventory::find($id);

        $vendors = $this->administrator->vendors()->isActive()->get()->lists('vendor_name', '_id');
        $vendors = [null => 'Select Vendor'] + $vendors;

        $models  = VendorModel::isActive()->where('vendor_id', $radioinventory->vendor_id)->get()->lists('model_name', '_id');
        $models  = [null => 'Select Model'] + $models;

        return $this->setView('radioinventory.edit', [
        											'record' => $radioinventory,
        											'vendors' => $vendors,
        											'models' => $models,
        										]);
    }

    public function postUpdate($id) {

	    // find the radioinventory
	    $this->radioinventory = RadioInventory::find($id);

    	// capture all user input data
    	$input = Input::all();

    	// validate the data
    	if( !$this->radioinventory->populate($input)->isValid('update', $id) ) {
    	//if( !$this->radioinventory->isValid($input, 'update', $id) ) {

			$errormessages = getVErrorMessages($this->radioinventory->vErrors);
			$response = [
							'status'  => 'verror',
							'payload' => $errormessages
						];

			return Response::json($response);
    	}

		// save and generate success message
		if($this->radioinventory->save()) {

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

		$radioinventory = new RadioInventory();
		$radioinventory->has_header = '0';

        $vendors = $this->administrator->vendors()->isActive()->get()->lists('vendor_name', '_id');
        $vendors = [null => 'Select Vendor'] + $vendors;

		$vid = Input::old('vendor_id', '0');
		$models  = VendorModel::isActive()->where('vendor_id', $vid)->get()->lists('model_name', '_id');
		$models  = [null => 'Select Model'] + $models;

        return $this->setView('radioinventory.import', [ 'record' => $radioinventory, 'vendors' => $vendors, 'models' => $models, ]);
    }

    public function postSaveimport() {

    	// capture all user input data
    	$input = Input::all();

    	$radioinventory = new RadioInventory();

    	// validate input
    	if( !$radioinventory->isValidImport($input) ) {
	        return Redirect::back()
	            ->withInput()
	            ->withErrors($radioinventory->vErrors);
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
			$line['vendor_id'] = Input::get('vendor_id', '0');
			$line['model_id']  = Input::get('model_id', '0');
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
			    	
			    	$object = new RadioInventory();
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
		if($radioinventory->saveimport($data)) {
			Session::flash('flash-done', 'File imported successfully.');
			return Redirect::route('radioinventory.index');
		}

		Session::flash('flash-error', 'Could not import file.');
        return Redirect::back()
            ->withInput();

    }

    public function getDestroy($id) {
    	// fetch and delete the record
		RadioInventory::destroy($id);
		Session::flash('flash-done', 'Record deleted successfully.');
		return Redirect::route('radioinventory.index');
    }


	public function missingMethod($parameters = array()) {
		//pr($parameters);
	    return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
	}

    public function getFlushparams() {
    	Session::forget('PARAMS_RADIOINVENTORYSEARCH');
    	echo 'all params flushed...';
    }

}
