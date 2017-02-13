<?php

class CarrierModelFeature extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_carrier_model_feature` (
  `_id` int(11) NOT NULL,
  `ft_group_id` int(11) NOT NULL DEFAULT '0',
  `ft_label` varchar(100) DEFAULT NULL,
  `ft_type` varchar(20) NOT NULL DEFAULT 'Text-box' COMMENT 'Label/Text-box/Text-area/Drop-down/Range/IP/IP Range',
  `ft_validation` varchar(1000) DEFAULT NULL,
  `ft_values` varchar(1000) DEFAULT NULL,
  `is_active` varchar(5) NOT NULL DEFAULT 'Yes',
  `ft_level` int(11) NOT NULL DEFAULT '1',
  `ft_disp_order` int(11) NOT NULL DEFAULT '1',
  `ft_fld_name` varchar(100) DEFAULT NULL,
  `ft_data_type` varchar(15) NOT NULL DEFAULT 'Text',
  `ft_value_assigned_by` varchar(20) NOT NULL DEFAULT 'Provisioner',
  `ft_decs` tinyint(4) NOT NULL DEFAULT '0',
  `ft_unique` varchar(5) NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/


	use SoftDeletingTrait;

	protected $table = 'tbl_carrier_model_feature';
	protected $primaryKey = '_id';
	protected $appends = [];

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 
                            'ft_label', 'ft_type', 'ft_validation', 'ft_values', 'is_active', 'ft_data_type', 
                            'ft_level', 'ft_disp_order', 'ft_value_assigned_by', 'ft_decs', 'ft_unique', 
                          ];
    protected $guarded  = [ '_id', 'ft_group_id', 'ft_fld_name' ];
    protected $dates = ['deleted_at'];

    // query scope for only level 1 features
    public function scopeIsLevel1($query) {
      return $query->where('ft_level', '1');
    }

    // relations
    // Models
    public function models() {
        return $this->belongsToMany('CarrierModel', 'tbl_carrier_model_model_feature', 'feature_id', 'model_id');
    }

    // Get Parent
    public function parent() {
        return CarrierModelFeature::find($this->ft_group_id);
    }

    // Get Children
    public function children($onlyActive=true) {
        $children = CarrierModelFeature::where( 'ft_group_id', $this->ft_group_id )->where('ft_level', '>', '1');

        if($onlyActive) $children = $children->isActive();

        return $children->orderBy('ft_disp_order', 'asc')->get();
    }

    public function hasChildren($onlyActive=true) {
        return !$this->children($onlyActive)->isEmpty();
    }

    // Pretty names for fields
    public static $niceNames = [
                                'ft_label'      => 'Feature Name',
                                'ft_values'     => 'Values',
                                'ft_value_assigned_by' => 'Assigned By', 
                                'ft_unique'     => 'Unique',
                              ];

    // validation error container
    public $vErrors;

    function __construct() {
      parent::__construct();

    }

	public static function boot() {
		parent::boot();

		// events in order of presedence
		static::saving(function($obj) {
			//$obj->name = ucwords($obj->name);
			return true;
		});

		static::creating(function($obj) {
			return true;
		});

		static::updating(function($obj) {
			return true;
		});

	}

	public static function search($pgn=1, $ppg=20, $params=array()) {

		$model = new CarrierModelFeature();

		$model = $model->where('ft_level', '1');

		if(isset($params['srchCMFName']) && trim($params['srchCMFName'])!='') {
			$model = $model->where('ft_label', 'like', '%' . $params['srchCMFName'] . '%');
		}

    // ordering
    if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
      $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

      $model = $model->orderBy($params['srchOBy'], $ord_type);
    }

		$results = $model->orderBy('ft_group_id', 'asc')->orderBy('ft_level', 'asc')->paginate($ppg);

		return $results;
	}

	public function isValid($case='create', $id=0) {

    $this->niceMessages['ft_values.required_if'] = ':attribute is required when Input Type is Drop-down.';

		$validation = Validator::make($this->attributes, $this->vRules($case, $id), $this->niceMessages);
		//$validation = Validator::make($input, $this->vRules($case, $id));
		$validation->setAttributeNames(static::$niceNames);

		if($validation->passes()) return true;
		$this->vErrors = $validation->messages();

		return false;
	}


    public function vRules($case='create', $id=0) {
      $rules = [];

      switch($case) {

        case 'update':
          $rules   = [
                        'ft_label'  => 'required|max:100|unique:tbl_vendor_model_feature,ft_label,'.$id.',_id',
                        'ft_values' => 'required_if:ft_type,Drop-down',
                        'ft_validation' => 'allowed:'.$this->allowedFtrValidations,
                        'ft_value_assigned_by' => 'required',
                        'ft_unique' => 'required',
                      ];
          break;

        case 'child':
          $rules   = [
                        'ft_label'  => 'required|max:100|unique:tbl_vendor_model_feature,ft_label,'.$id.',_id',
                        'ft_values' => 'required_if:ft_type,Drop-down',
                        'ft_validation' => 'allowed:'.$this->allowedFtrValidations,
                        'ft_value_assigned_by' => 'required',
                        'ft_unique' => 'required',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'ft_label'  => 'required|max:100|unique:tbl_vendor_model_feature,ft_label,'.$id.',_id',
                        'ft_values' => 'required_if:ft_type,Drop-down',
                        'ft_validation' => 'allowed:'.$this->allowedFtrValidations,
                        'ft_value_assigned_by' => 'required',
                        'ft_unique' => 'required',
                      ];
      }

      return $rules;

    }

    public function savefeature($input) {

      try {
        DB::beginTransaction();

        // preparing field name
        $this->ft_fld_name = $this->getFeatureFieldName($this->ft_label, 'cmf_');

        // saving self
        $this->save();

        // setting group id
        $this->ft_group_id = $this->_id;
        $this->save();

        // saving children
        $child = isset($input['child']) && is_array($input['child']) ? $input['child'] : [];

        foreach ($child as $k => $c) {
          if(isset($c['ft_label']) && !empty($c['ft_label'])) {
            $object = new CarrierModelFeature($c);
            $object->populate($c);
            $object->ft_group_id = $this->ft_group_id;
            $object->ft_fld_name = $object->getFeatureFieldName($object->ft_label, 'cmf_');

            $object->save();
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

    public function updatefeature($input) {

      try {
        DB::beginTransaction();

        // saving self
        $this->save();

        // saving children
        $child = isset($input['child']) && is_array($input['child']) ? $input['child'] : [];
        $keys  = isset($input['keys']) && is_array($input['keys']) ? $input['keys'] : [];

        foreach ($child as $k => $c) {
          if(isset($c['ft_label']) && !empty($c['ft_label'])) {
            $object = CarrierModelFeature::findOrNew($keys[$k]);
            $object->populate($c);

            if(empty($keys[$k])) {
              $object->ft_group_id = $this->ft_group_id;
              $object->ft_fld_name = $object->getFeatureFieldName($object->ft_label, 'cmf_');
            }

            $object->save();
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