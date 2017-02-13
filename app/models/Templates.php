<?php

class Templates extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_template` (
  `_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `tmpl_name` varchar(100) NOT NULL,
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `vendor_model_id` int(11) NOT NULL DEFAULT '0',
  `need_vendor_sku` varchar(5) NOT NULL DEFAULT 'Yes',
  `carrier_id` int(11) NOT NULL DEFAULT '0',
  `carrier_model_id` int(11) NOT NULL DEFAULT '0',
  `need_carrier_sku` varchar(5) NOT NULL DEFAULT 'Yes',
  `cards_per_radio` int(11) NOT NULL DEFAULT '1',
  `is_active` varchar(5) NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

	//use SoftDeletingTrait;


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_template';
	protected $primaryKey = '_id';

	public $incrementing = true;
	public $timestamps = true;

	protected $fillable = [ 
							'customer_id', 'tmpl_name', 
							'vendor_id', 'vendor_model_id', 'need_vendor_sku', 
							'carrier_id', 'carrier_model_id', 'need_carrier_sku', 
							'cards_per_radio', 'is_active' 
						  ];
	protected $guarded  = [ '_id' ];
	protected $dates = ['deleted_at'];

	// custom properties
	protected $niceNames;

	//protected $appends = ['accountrep'];

	// query scope for only level 1 features
	public function scopeIsLevel1($query) {
	  return $query->where('ft_level', '1');
	}

	// relations
	// // users
	// public function users() {
	//     return $this->belongsToMany('USER', 'tbl_group_user', 'group_id', 'user_id');
	// }

	// Template Vendor Model Features
	public function vendormodelfeatures() {
		return $this->hasMany('TemplateVendorModelFeature', 'tmpl_id', '_id');
	}

	// Template Carrier Model Features
	public function carriermodelfeatures() {
		return $this->hasMany('TemplateCarrierModelFeature', 'tmpl_id', '_id');
	}

	// Groups
	public function groups() {
		return $this->belongsToMany('Groups', 'tbl_group_template', 'tmpl_id', 'group_id');
	}

	// Vendor
	public function vendor() {
		return $this->belongsTo('Vendors', 'vendor_id', '_id')->withTrashed();
	}

	// Vendor Model
	public function vendormodel() {
		return $this->belongsTo('VendorModel', 'vendor_model_id', '_id')->withTrashed();
	}

	// Carrier
	public function carrier() {
		return $this->belongsTo('Carrier', 'carrier_id', '_id')->withTrashed();
	}

	// Carrier Model
	public function carriermodel() {
		return $this->belongsTo('CarrierModel', 'carrier_model_id', '_id')->withTrashed();
	}

	// Template provisions
	public function provisions() {
		return $this->hasMany('Provision', 'tmpl_id', '_id');
	}

	// Template provisioned items
	public function provisioneditems() {
		return $this->hasMany('ProvisionRadioItem', 'tmpl_id', '_id');
	}

	public function needvendorsno() {
	  return $this->need_vendor_sku == 'Yes';
	}

	public function needcarriersno() {
	  return !empty($this->carrier_id) && ($this->need_carrier_sku == 'Yes');
	}

	// // Template Vendor Model Features
	// public function vendormodelfeatures() {
	//     return $this->belongsToMany('VendorModelFeature', 'tbl_template_vendor_model_feature', 'tmpl_id', 'feature_id')
	//                                 ->withPivot('feature_type', 'feature_fld_name', 'value', 'value2');
	// }

	// // Template Carrier Model Features
	// public function carriermodelfeatures() {
	//     return $this->belongsToMany('CarrierModelFeature', 'tbl_template_carrier_model_feature', 'tmpl_id', 'feature_id')
	//                                 ->withPivot('feature_type', 'feature_fld_name', 'value', 'value2');
	// }

	// // Name
	// public function getNameAttribute() {
	//   return $this->attributes['first_name'] . (!empty($this->attributes['first_name']) ? ' ' : '') . $this->attributes['last_name'];
	// }


	// validation error container
	public $vErrors;

	function __construct() {
	  parent::__construct();

	  // Pretty names for fields
	  $this->niceNames = [
							'customer_id'      => 'Customer',
							'tmpl_name'        => 'Template Name',
							'vendor_id'        => 'Vendor',
							'vendor_model_id'  => 'Vendor Model',
							'carrier_id'       => 'Carrier',
							'carrier_model_id' => 'Carrier Model',
							'is_active'        => 'Active',
						  ];

	}

	public static function boot() {
		parent::boot();

		// events in order of presedence
		static::saving(function($obj) {
		  return true;
		});

		static::creating(function($obj) {
		  return true;
		});

		static::updating(function($obj) {
		  return true;
		});

	}

	public function search($pgn=1, $ppg=20, $params=array()) {

	  $app = App::make('myApp');

	  $model = new Templates();
	  $model = $model->where('customer_id', $app->pid);

	  // filtering for normal(operator) users
	  // showing only those records which they are related to
	  if(!$app->isCustAdmin) {
		$tmps = [];// container for templates which user has access to
		$appUser = USER::find($app->uid);// get logged in user

		$uts = $appUser->templates();// get all templates for logged in user

		// loop for each template and get the id out of it
		if(count($uts)>0) {
		  foreach($uts as $t) {
			$tmps[] = $t->_id;
		  }
		}

		// filter with the found vendor model id
		$model = $model->whereIn('_id', $tmps);
	  }


	  if(isset($params['srchTmplName']) && trim($params['srchTmplName'])!='') {
		$model = $model->where('tmpl_name', 'like', '%' . $params['srchTmplName'] . '%');
	  }

	  // ordering
	  if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
		$ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

		$model = $model->orderBy($params['srchOBy'], $ord_type);
	  }

	  $results = $model->orderBy('tmpl_name', 'asc')->paginate($ppg);

		return $results;
	}

	public function isValid($input, $case='create', $id=0) {

	  $vmid = Input::get('vendor_model_id', '0');
	  $cmid = Input::get('carrier_model_id', '0');

	  //$validation = Validator::make($this->attributes, $this->vRules($case, $id));
//pr($this->vRules($case, $id, $vmid, $cmid), 1);
	  $validation = Validator::make($input, $this->vRules($case, $id, $vmid, $cmid, $input), $this->niceMessages);
	  $validation->setAttributeNames($this->niceNames);

	  if($validation->passes()) return true;
	  $this->vErrors = $validation->messages();

	  return false;
	}

	public function vRules($case='create', $id=0, $vmid=0, $cmid=0, $input=[]) {

		// dynamic rules for template properties, vendor model and carrier model features
		$vmfRules = $cmfRules = $rules = [];

		switch($case) {

			case 'update':
			  $rules   = [
							'customer_id'      => 'sometimes|required',
							'tmpl_name'        => 'required|max:100|unique:tbl_template,tmpl_name,'.$id.',_id,deleted_at,NULL',
							'vendor_id'        => 'required',
							'vendor_model_id'  => 'required',
							//'carrier_id'       => 'required',
							'carrier_model_id' => 'required_with:carrier_id',
							'is_active'        => 'required',
						  ];
			  break;

			case 'create':
			default:
			  $rules   = [
							'customer_id'      => 'sometimes|required',
							'tmpl_name'        => 'required|max:100|unique:tbl_template,tmpl_name,'.$id.',_id,deleted_at,NULL',
							'vendor_id'        => 'required',
							'vendor_model_id'  => 'required',
							//'carrier_id'       => 'required',
							'carrier_model_id' => 'required_with:carrier_id',
							'is_active'        => 'required',
						  ];
		}

		// GENERATING VENDOR MODEL FEATURE VALIDATION RULES
		if(isset($input['vmfkeys']) && count($input['vmfkeys'])>0) {

			$new_vmftrs = $pre_vmftrs = $vmFeatures = $allVmNF = $vmNF = [];
			foreach ($input['vmfkeys'] as $fld => $kval) {
				if(empty($kval['tftid'])) $new_vmftrs[] = $kval['ftid'];
				else $pre_vmftrs[] = $kval['tftid'];
			}

			$new_vmftrs = array_unique($new_vmftrs);
			$pre_vmftrs = array_unique($pre_vmftrs);

			$vmFeatures = TemplateVendorModelFeature::isActive()
													->whereIn('_id', $pre_vmftrs)
													->where('ft_type', '<>', 'Label')
													->get()
													->toArray();

			$allVmNF = VendorModelFeature::isActive()
									->whereIn('_id', $new_vmftrs)
									->where('ft_type', '<>', 'Label')
									->get()
									->toArray();

			foreach ($allVmNF as $vmf) {
				$vmNF[$vmf['_id']] = $vmf;
			}

			foreach ($input['vmfkeys'] as $fld => $kval) {
				if(empty($kval['tftid'])) {
					$ftid = $kval['ftid'];
					$newVMF = $vmNF[$ftid];
					$newVMF['ft_fld_name'] = $fld;
					$newVMF['ft_label']    = $kval['label'];

					$vmFeatures[] = $newVMF;
				}
			}

			$vmfRules = count($vmFeatures) > 0 ? $this->getVendorModelFeatureRules($vmFeatures) : [];
		}

		// GENERATING CARRIER MODEL FEATURE VALIDATION RULES
		if(isset($input['cmfkeys']) && count($input['cmfkeys'])>0) {

			$new_cmftrs = $pre_cmftrs = $cmFeatures = $allCmNF = $cmNF = [];
			foreach ($input['cmfkeys'] as $fld => $kval) {
				if(empty($kval['tftid'])) $new_cmftrs[] = $kval['ftid'];
				else $pre_cmftrs[] = $kval['tftid'];
			}

			$new_cmftrs = array_unique($new_cmftrs);
			$pre_cmftrs = array_unique($pre_cmftrs);

			$cmFeatures = TemplateCarrierModelFeature::isActive()
													->whereIn('_id', $pre_cmftrs)
													->where('ft_type', '<>', 'Label')
													->get()
													->toArray();

			$allCmNF = CarrierModelFeature::isActive()
									->whereIn('_id', $new_cmftrs)
									->where('ft_type', '<>', 'Label')
									->get()
									->toArray();

			foreach ($allCmNF as $cmf) {
				$cmNF[$cmf['_id']] = $cmf;
			}

			foreach ($input['cmfkeys'] as $fld => $kval) {
				if(empty($kval['tftid'])) {
					$ftid = $kval['ftid'];
					$newCMF = $cmNF[$ftid];
					$newCMF['ft_fld_name'] = $fld;
					$newCMF['ft_label']    = $kval['label'];

					$cmFeatures[] = $newCMF;
				}
			}

			$cmfRules   = count($cmFeatures) > 0 ? $this->getCarrierModelFeatureRules($cmFeatures) : [];
		}

		$rules = array_merge( $rules, $vmfRules, $cmfRules);

		return $rules;
	}

	protected function getVendorModelFeatureRules( $vmFeatures=[] ) {

	  $rules = [];

	  foreach($vmFeatures as $ft) {

		$ft_type = $ft['ft_type'];
		$lineRule = '';

		$fld_name  = 'vmf.' . $ft['ft_fld_name'] . '.' . ( $ft['ft_data_type'] == 'Text' ? 'varvalue' : 'decvalue' );
		$fld_name2 = 'vmf.' . $ft['ft_fld_name'] . '.' . ( $ft['ft_data_type'] == 'Text' ? 'varvalue2' : 'decvalue2' );

		// $fld_name  = 'vmf.' . $ft['ft_fld_name'] . '.value';
		// $fld_name2 = 'vmf.' . $ft['ft_fld_name'] . '.value2';

		$vlds = explode("|", $ft['ft_validation']);

		// for distinct validation
		$validateDistinct = in_array('distinct', $vlds);

		// removing distinct validation key from array
		if($validateDistinct) {
		  $dk = array_keys($vlds, 'distinct');
		  foreach($dk as $k) unset($vlds[$k]);
		  $ft['ft_validation'] = implode('|', $vlds);
		}

		$ft_id = isset($ft['ft_id']) && !empty($ft['_id']) ? $ft['_id'] : '0';

		$db_fld_name  = $ft['ft_data_type'] == 'Text' ? 'varvalue' : 'decvalue';
		$db_fld_name2 = $ft['ft_data_type'] == 'Text' ? 'varvalue2' : 'decvalue2';

		switch($ft_type) {

		  case 'IP':

			$fld_name  = 'vmf.' . $ft['ft_fld_name'] . '.decvalue';

			$lineRule = 'sometimes|' . $ft['ft_validation'];
			$lineRule = rtrim($lineRule, "|");
			$lineRule = in_array('ip', $vlds) ? $lineRule : $lineRule . '|ip';

			if($validateDistinct)
			  $lineRule .= '|distinctip:TemplateVendorModelFeature,' . $ft_type . ',' . $db_fld_name . ',NULL,' . $ft_id . ',_id';

			$rules[$fld_name] = $lineRule;
			$this->niceNames[$fld_name] = $ft['ft_label'];

			break;

		  case 'IP Range':

			$fld_name  = 'vmf.' . $ft['ft_fld_name'] . '.decvalue';
			$fld_name2 = 'vmf.' . $ft['ft_fld_name'] . '.decvalue2';

			// start field rules
			$stVrule  = 'sometimes|' . $ft['ft_validation'];
			$stVrule  = rtrim($stVrule, "|");
			$stVrule  = in_array('ip', $vlds) ? $stVrule : $stVrule . '|ip';
			$stVrule .= '|requires:' . $fld_name2;
			$stVrule .= '|lessthaneqip:' . $fld_name2;

			if($validateDistinct)
			  $stVrule .= '|distinctiprange:TemplateVendorModelFeature,' . $ft_type . ',' . $db_fld_name . ',' . $db_fld_name2 . ',' . $ft_id . ',_id';

			//$stVrule .= '|distinctiprange:TemplateVendorModelFeature,' . $ft_id . ',_id';

			$rules[$fld_name] = $stVrule;
			$this->niceNames[$fld_name] = 'Start ' . $ft['ft_label'];

			// end field rules
			$enVrule  = 'sometimes|' . $ft['ft_validation'];
			$enVrule  = rtrim($enVrule, "|");
			$enVrule  = in_array('ip', $vlds) ? $enVrule : $enVrule . '|ip';
			$enVrule .= '|requires:' . $fld_name;
			$enVrule .= '|greaterthaneqip:' . $fld_name;

			if($validateDistinct)
			  $enVrule .= '|distinctiprange:TemplateVendorModelFeature,' . $ft_type . ',' . $db_fld_name . ',' . $db_fld_name2 . ',' . $ft_id . ',_id';

			$rules[$fld_name2] = $enVrule;
			$this->niceNames[$fld_name2] = 'End ' . $ft['ft_label'];

			break;

		  case 'Range':

			// start field rules
			$stVrule  = 'sometimes|' . $stIPRVrule . $ft['ft_validation'];
			$stVrule  = rtrim($stVrule, "|");
			$stVrule .= '|requires:' . $fld_name2;
			$stVrule .= '|lessthan:' . $fld_name2;

			if($validateDistinct)
			  $stVrule .= '|distinctrange:TemplateVendorModelFeature,' . $ft_type . ',' . $db_fld_name . ',' . $db_fld_name2 . ',' . $ft_id . ',_id';

			$rules[$fld_name] = $stVrule;
			$this->niceNames[$fld_name] = 'Start ' . $ft['ft_label'];

			// end field rules
			$enVrule  = 'sometimes|' . $enIPRVrule . $ft['ft_validation'];
			$enVrule  = rtrim($enVrule, "|");
			$enVrule  = in_array('ip', $vlds) ? $enVrule : $enVrule . '|ip';
			$enVrule .= '|requires:' . $fld_name;
			$enVrule .= '|greaterthan:' . $fld_name;

			if($validateDistinct)
			  $enVrule .= '|distinctrange:TemplateVendorModelFeature,' . $ft_type . ',' . $db_fld_name . ',' . $db_fld_name2 . ',' . $ft_id . ',_id';

			$rules[$fld_name2] = $enVrule;
			$this->niceNames[$fld_name2] = 'End ' . $ft['ft_label'];

			break;

		  case 'Text-area':
			$fld_name  = 'vmf.' . $ft['ft_fld_name'] . '.txtvalue';
			$db_fld_name = 'txtvalue';
		  case 'Text-box':
		  case 'Drop-down':
		  default:
			$lineRule = 'sometimes|'.$ft['ft_validation'];
			$lineRule = rtrim($lineRule, "|");

			if($validateDistinct)
			  $lineRule .= '|distinct:TemplateVendorModelFeature,' . $ft_type . ',' . $db_fld_name . ',NULL,' . $ft_id . ',_id';

			$rules[$fld_name] = $lineRule;
			$this->niceNames[$fld_name] = $ft['ft_label'];
		}

	  }

	  return $rules;

	}

	protected function getCarrierModelFeatureRules( $cmFeatures=[] ) {

	  $rules = [];

	  foreach($cmFeatures as $ft) {

		$ft_type = $ft['ft_type'];
		$lineRule = '';

		$fld_name  = 'cmf.' . $ft['ft_fld_name'] . '.' . ( $ft['ft_data_type'] == 'Text' ? 'varvalue' : 'decvalue' );
		$fld_name2 = 'cmf.' . $ft['ft_fld_name'] . '.' . ( $ft['ft_data_type'] == 'Text' ? 'varvalue2' : 'decvalue2' );

		// $fld_name  = 'cmf.' . $ft['ft_fld_name'] . '.value';
		// $fld_name2 = 'cmf.' . $ft['ft_fld_name'] . '.value2';

		$vlds = explode("|", $ft['ft_validation']);

		// for distinct validation
		$validateDistinct = in_array('distinct', $vlds);

		// removing distinct validation key from array
		if($validateDistinct) {
		  $dk = array_keys($vlds, 'distinct');
		  foreach($dk as $k) unset($vlds[$k]);
		  $ft['ft_validation'] = implode('|', $vlds);
		}

		$ft_id = isset($ft['ft_id']) && !empty($ft['_id']) ? $ft['_id'] : '0';

		$db_fld_name  = $ft['ft_data_type'] == 'Text' ? 'varvalue' : 'decvalue';
		$db_fld_name2 = $ft['ft_data_type'] == 'Text' ? 'varvalue2' : 'decvalue2';

		switch($ft_type) {

		  case 'IP':

			$fld_name  = 'cmf.' . $ft['ft_fld_name'] . '.decvalue';

			$lineRule = 'sometimes|' . $ft['ft_validation'];
			$lineRule = rtrim($lineRule, "|");
			$lineRule = in_array('ip', $vlds) ? $lineRule : $lineRule . '|ip';

			if($validateDistinct)
			  $lineRule .= '|distinctip:TemplateCarrierModelFeature,' . $ft_type . ',' . $db_fld_name . ',NULL,' . $ft_id . ',_id';

			$rules[$fld_name] = $lineRule;
			$this->niceNames[$fld_name] = $ft['ft_label'];

			break;

		  case 'IP Range':

			$fld_name  = 'cmf.' . $ft['ft_fld_name'] . '.decvalue';
			$fld_name2 = 'cmf.' . $ft['ft_fld_name'] . '.decvalue2';

			// start field rules
			$stVrule  = 'sometimes|' . $ft['ft_validation'];
			$stVrule  = rtrim($stVrule, "|");
			$stVrule .= '|requires:' . $fld_name2;
			$stVrule .= '|lessthaneqip:' . $fld_name2;

			if($validateDistinct)
			  $stVrule .= '|distinctiprange:TemplateCarrierModelFeature,' . $ft_type . ',' . $db_fld_name . ',' . $db_fld_name2 . ',' . $ft_id . ',_id';

			$rules[$fld_name] = $stVrule;
			$this->niceNames[$fld_name] = 'Start ' . $ft['ft_label'];

			// end field rules
			$enVrule  = 'sometimes|' . $ft['ft_validation'];
			$enVrule  = rtrim($enVrule, "|");
			$enVrule  = in_array('ip', $vlds) ? $enVrule : $enVrule . '|ip';
			$enVrule .= '|requires:' . $fld_name;
			$enVrule .= '|greaterthaneqip:' . $fld_name;

			if($validateDistinct)
			  $enVrule .= '|distinctiprange:TemplateCarrierModelFeature,' . $ft_type . ',' . $db_fld_name . ',' . $db_fld_name2 . ',' . $ft_id . ',_id';

			$rules[$fld_name2] = $enVrule;
			$this->niceNames[$fld_name2] = 'End ' . $ft['ft_label'];

			break;

		  case 'Range':

			// start field rules
			$stVrule  = 'sometimes|' . $stIPRVrule . $ft['ft_validation'];
			$stVrule  = rtrim($stVrule, "|");
			$stVrule .= '|requires:' . $fld_name2;
			$stVrule .= '|lessthan:' . $fld_name2;

			if($validateDistinct)
			  $stVrule .= '|distinctrange:TemplateCarrierModelFeature,' . $ft_type . ',' . $db_fld_name . ',' . $db_fld_name2 . ',' . $ft_id . ',_id';

			$rules[$fld_name] = $stVrule;
			$this->niceNames[$fld_name] = 'Start ' . $ft['ft_label'];

			// end field rules
			$enVrule  = 'sometimes|' . $enIPRVrule . $ft['ft_validation'];
			$enVrule  = rtrim($enVrule, "|");
			$enVrule  = in_array('ip', $vlds) ? $enVrule : $enVrule . '|ip';
			$enVrule .= '|requires:' . $fld_name;
			$enVrule .= '|greaterthan:' . $fld_name;

			if($validateDistinct)
			  $enVrule .= '|distinctrange:TemplateCarrierModelFeature,' . $ft_type . ',' . $db_fld_name . ',' . $db_fld_name2 . ',' . $ft_id . ',_id';

			$rules[$fld_name2] = $enVrule;
			$this->niceNames[$fld_name2] = 'End ' . $ft['ft_label'];

			break;

		  case 'Text-area':
			$fld_name  = 'cmf.' . $ft['ft_fld_name'] . '.txtvalue';
			$db_fld_name = 'txtvalue';
		  case 'Text-box':
		  case 'Drop-down':
		  default:
			$lineRule = 'sometimes|'.$ft['ft_validation'];
			$lineRule = rtrim($lineRule, "|");

			if($validateDistinct)
			  $lineRule .= '|distinct:TemplateCarrierModelFeature,' . $ft_type . ',' . $db_fld_name . ',NULL,' . $ft_id . ',_id';

			$rules[$fld_name] = $lineRule;
			$this->niceNames[$fld_name] = $ft['ft_label'];
		}

	  }

	  return $rules;

	}

	public function savetemplate($input=[]) {

	  try {

		DB::beginTransaction();

		$this->populate($input);
		$this->cards_per_radio = '1';
		$this->_id = null;

		$this->save();

		//$tid = 0;
		$tid = $this->_id;

		$this->groups()->sync(Input::get('grp_ids', []));

		// saving vendor model features
		if(isset($input['vmfkeys']) && count($input['vmfkeys'])>0) {

			foreach($input['vmfkeys'] as $fld => $vmf) {
				$tvmf = [];
				$fid = $vmf['ftid'];
				$lbl = $vmf['label'];
				$tvmf['tmpl_id'] = $tid;
				$tvmf['ft_id']   = $fid;
				$tvmf = $tvmf + VendorModelFeature::find($fid)->getAttributes();
				unset($tvmf['_id']);
				$tvmf['ft_label'] = $lbl;
				$tvmf['ft_fld_name'] = $fld;

				if(isset($input['vmf']) && isset($input['vmf'][$fld])) {
					$tvmf = $tvmf + $input['vmf'][$fld];
				}

				$tvmfm = new TemplateVendorModelFeature();
				$tvmfm->populate($tvmf);
				$tvmfm->save();
			}
		}

		// saving carrier model features
		if(isset($input['cmfkeys']) && count($input['cmfkeys'])>0) {

		  foreach($input['cmfkeys'] as $fld => $cmf) {
			$tcmf = [];
			$fid = $cmf['ftid'];
			$lbl = $cmf['label'];
			$tcmf['tmpl_id'] = $tid;
			$tcmf['ft_id']   = $fid;
			$tcmf = $tcmf + CarrierModelFeature::find($fid)->getAttributes();
			unset($tcmf['_id']);
			$tcmf['ft_label'] = $lbl;
			$tcmf['ft_fld_name'] = $fld;

			if(isset($input['cmf']) && isset($input['cmf'][$fld])) {
			  $tcmf = $tcmf + $input['cmf'][$fld];
			}

			$tcmfm = new TemplateCarrierModelFeature();
			$tcmfm->populate($tcmf);
			$tcmfm->save();

		  }
		}

		// DB::rollback();
		// pr('i rolled back...');
	  }
	  catch(Exception $e) {
		DB::rollback();
		// pr($e->getMessage(), 1);
		return false;
	  }
	  DB::commit();
	  return true;
	}


	public function updatetemplate($input=[]) {

	  try {

		DB::beginTransaction();

		$this->populate($input);
		$this->cards_per_radio = '1';

		$this->save();

		//$tid = 0;
		$tid = $this->_id;

		$this->groups()->sync(Input::get('grp_ids', []));

		$vmid = Input::get('vmodel', 0);
		$cmid = Input::get('cmodel', 0);

		// // deleting existing vendor model features if new model selected
		// if(empty($vmid)) {
		//   $tvmfids = $this->vendormodelfeatures()->lists('_id');
		//   TemplateVendorModelFeature::destroy($tvmfids);
		// }

		// // deleting existing carrier model features if new model selected
		// if(empty($cmid)) {
		//   $tcmfids = $this->carriermodelfeatures()->lists('_id');
		//   TemplateCarrierModelFeature::destroy($tcmfids);
		// }

		// saving vendor model features
		if(isset($input['vmfkeys']) && count($input['vmfkeys'])>0) {
			foreach($input['vmfkeys'] as $fld => $vmf) {
				$tvmfm = null;
				$tfid = $vmf['tftid'];
				$fid = $vmf['ftid'];
				$lbl = $vmf['label'];
				if(empty($tfid)) {
					$tvmf = [];
					$tvmf['tmpl_id'] = $tid;
					$tvmf['ft_id']   = $fid;
					$tvmf = $tvmf + VendorModelFeature::find($fid)->getAttributes();
					unset($tvmf['_id']);
					$tvmf['ft_label'] = $lbl;
					$tvmf['ft_fld_name'] = $fld;

					if(isset($input['vmf']) && isset($input['vmf'][$fld])) {
						$tvmf = $tvmf + $input['vmf'][$fld];
					}

					$tvmfm = new TemplateVendorModelFeature();
					$tvmfm->populate($tvmf);
				}
				else {
					$tvmfm = TemplateVendorModelFeature::find($tfid);

					if(isset($input['vmf']) && isset($input['vmf'][$fld])) {
						$tvmfm->populate($input['vmf'][$fld]);
					}
				}
				if($tvmfm) $tvmfm->save();
			}
		}

		// saving carrier model features
		if(isset($input['cmfkeys']) && count($input['cmfkeys'])>0) {
			foreach($input['cmfkeys'] as $fld => $cmf) {
				$tcmfm = null;
				$tfid = $cmf['tftid'];
				$fid = $cmf['ftid'];
				$lbl = $cmf['label'];
				if(empty($tfid)) {
					$tcmf = [];
					$tcmf['tmpl_id'] = $tid;
					$tcmf['ft_id']   = $fid;
					$tcmf = $tcmf + CarrierModelFeature::find($fid)->getAttributes();
					unset($tcmf['_id']);
					$tcmf['ft_label'] = $lbl;
					$tcmf['ft_fld_name'] = $fld;

					if(isset($input['cmf']) && isset($input['cmf'][$fld])) {
						$tcmf = $tcmf + $input['cmf'][$fld];
					}

					$tcmfm = new TemplateCarrierModelFeature();
					$tcmfm->populate($tcmf);
				}
				else {
					$tcmfm = TemplateCarrierModelFeature::find($tfid);

					if(isset($input['cmf']) && isset($input['cmf'][$fld])) {
						$tcmfm->populate($input['cmf'][$fld]);
					}
				}
				if($tcmfm) $tcmfm->save();
			}
		}
	  }
	  catch(Exception $e) {
		DB::rollback();
		//pr($e->getMessage(), 1);
		return false;
	  }
	  DB::commit();
	  return true;
	}

}