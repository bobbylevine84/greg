<?php

class Carrier extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_carrier` (
  `_id` int(11) NOT NULL,
  `carrier_name` varchar(100) DEFAULT NULL,
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
    protected $table = 'tbl_carrier';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 'carrier_name', 'is_active' ];
    protected $guarded  = [ '_id' ];
    protected $dates = ['deleted_at'];

    //protected $appends = ['accountrep'];

    // relations
    // Customers
    public function customers() {
        return $this->belongsToMany('Customer', 'tbl_customer_carrier', 'carrier_id', 'customer_id');
    }

    // Models
    public function models() {
        return $this->hasMany('CarrierModel', 'carrier_id', '_id');
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
                                'carrier_name' => 'Carrier Name',
                                'is_active'    => 'Active',
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

      $model = new Carrier();

      if(isset($params['srchCName']) && trim($params['srchCName'])!='') {
        $model = $model->where('carrier_name', 'like', '%' . $params['srchCName'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->paginate($ppg);

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
                        'carrier_name' => 'required|max:100',
                        'is_active'    => 'required',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'carrier_name' => 'required|max:100',
                        'is_active'    => 'required',
                      ];
      }

      return $rules;

    }

    public function savecarrier() {

      try {
        DB::beginTransaction();

        // saving self
        $this->save();

        $this->customers()->sync(Input::get('cust_ids', []));

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