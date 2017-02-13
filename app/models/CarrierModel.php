<?php

class CarrierModel extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_carrier_model` (
  `_id` int(11) NOT NULL,
  `carrier_id` int(11) NOT NULL DEFAULT '0',
  `model_name` varchar(100) DEFAULT NULL,
  `is_active` varchar(5) NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

    use SoftDeletingTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_carrier_model';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 'carrier_id', 'model_name', 'is_active' ];
    protected $guarded  = [ '_id' ];
    protected $dates = ['deleted_at'];

    //protected $appends = ['accountrep'];

    // relations
    // Customers
    public function modelfeatures() {
        return $this->belongsToMany('CarrierModelFeature', 'tbl_carrier_model_model_feature', 'model_id', 'feature_id');
    }

    // Carrier
    public function carrier() {
        return $this->belongsTo('Carrier', 'carrier_id', '_id')->withTrashed();
    }

    // Customers
    public function customers() {
        return $this->belongsToMany('Customer', 'tbl_customer_carrier_model', 'carrier_model_id', 'customer_id');
    }

    // Model Features with child
    public function modelfeatureswithchild($withLabel=true, $onlyActive=true) {
        $fts = $onlyActive 
                ? $this->modelfeatures()->isActive()->get()->lists('_id') 
                : $this->modelfeatures()->lists('_id');

        //return $fts;

        $vmf = new CarrierModelFeature();
        if($onlyActive) $vmf = $vmf->isActive();
        if(!$withLabel) $vmf = $vmf->where('ft_type', '<>', 'Label');

        return $vmf->whereIn('ft_group_id', $fts)->get();
    }

    // Inventory
    public function inventory() {
        return $this->hasMany('CarrierInventory', 'model_id', '_id');
    }

    // // On Boarding
    // public function onboarding() {
    //     return $this->morphOne('OnBoarding', 'master');
    // }

    // // Industries
    // public function industries() {
    //     return $this->belongsToMany('Industry', 'tbl_e2et_var_industries', 'var_id', 'inds_id');
    // }

    // // Leads
    // public function leads() {
    //     return $this->hasMany('Lead', 'var_id', 'var_id');
    // }

    // // Additional attributes
    // // Account Rep
    // public function getAccountrepAttribute() {
    //     return $this->onboarding->accountrep;
    // }

    // // Name
    // public function getNameAttribute() {
    //   return $this->attributes['first_name'] . (!empty($this->attributes['first_name']) ? ' ' : '') . $this->attributes['last_name'];
    // }

    // Pretty names for fields
    public static $niceNames = [
                                'carrier_id'  => 'Carrier',
                                'model_name'  => 'Model Name',
                                'is_active'   => 'Active',
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

      $model = new CarrierModel();
      $model = $model->join('tbl_carrier', 'tbl_carrier_model.carrier_id', '=', 'tbl_carrier._id');
      //$model = $model->select('tbl_model._id', 'tbl_model.is_active', 'model_name', 'carrier_name');
      $model = $model->select('tbl_carrier_model.*', 'tbl_carrier.carrier_name');
      //$model = new Models();

      if(isset($params['srchMName']) && trim($params['srchMName'])!='') {
        $model = $model->where('model_name', 'like', '%' . $params['srchMName'] . '%');
      }
      if(isset($params['srchCName']) && trim($params['srchCName'])!='') {
        $model = $model->where('carrier_name', 'like', '%' . $params['srchCName'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->orderBy('carrier_name', 'asc')->orderBy('model_name', 'asc')->paginate($ppg);

    	return $results;
    }

    public function isValid($case='create', $id=0) {

      $validation = Validator::make($this->attributes, $this->vRules($case, $id));
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
                        'carrier_id'  => 'required',
                        'model_name'  => 'required|max:100',
                        'is_active'   => 'required',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'carrier_id'  => 'required',
                        'model_name'  => 'required|max:100',
                        'is_active'   => 'required',
                      ];
      }

      return $rules;

    }

    public function savemodel() {

      try {
        DB::beginTransaction();

        // saving self
        $this->save();

        $this->customers()->sync(Input::get('cust_ids', []));

        $this->modelfeatures()->sync(Input::get('feature_ids', []));

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