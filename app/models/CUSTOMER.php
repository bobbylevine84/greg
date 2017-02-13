<?php

class CUSTOMER extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `_id` int(11) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'CUSTOMER',
  `comp_name` varchar(100) DEFAULT NULL,
  `con_name` varchar(100) DEFAULT NULL,
  `con_email` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `ruk` varchar(10) DEFAULT NULL,
  `is_active` VARCHAR(5) NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

    //use SoftDeletingTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_customer';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 'comp_name', 'con_name', 'con_email', 'is_active' ];
    protected $guarded  = [ '_id', 'ruk', 'username', 'password', 'password_confirmation', 'user_type' ];
    protected $dates = ['deleted_at'];

    //protected $appends = ['accountrep'];

    // relations
    // Vendors
    public function vendors() {
        return $this->belongsToMany('Vendors', 'tbl_customer_vendor', 'customer_id', 'vendor_id');
    }

    // Vendor Models
    public function vendormodels() {
        return $this->belongsToMany('VendorModel', 'tbl_customer_vendor_model', 'customer_id', 'vendor_model_id');
    }

    // Carriers
    public function carriers() {
        return $this->belongsToMany('Carrier', 'tbl_customer_carrier', 'customer_id', 'carrier_id');
    }

    // Carrier Models
    public function carriermodels() {
        return $this->belongsToMany('CarrierModel', 'tbl_customer_carrier_model', 'customer_id', 'carrier_model_id');
    }

    // Templates
    public function templates() {
        return $this->hasMany('Templates', 'customer_id', '_id');
    }

    // // On Boarding
    // public function onboarding() {
    //     return $this->morphOne('OnBoarding', 'master');
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
                                'comp_name'             => 'Company Name',
                                'con_name'              => 'Contact Name',
                                'con_email'             => 'Contact Email',
                                'username'              => 'Username',
                                'password'              => 'Password',
                                'password_confirmation' => 'Confirm Password',
                                'is_active'             => 'Active',
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
          if(isset($obj->password_confirmation)) unset($obj->password_confirmation);

          $pswd = Input::get('password', '');
          if(!empty($pswd)) $obj->password = Hash::make($pswd);
          else unset($obj->password);

          return true;
        });

        static::creating(function($obj) {
          $obj->user_type = 'CUSTOMER';

          return true;
        });

        static::updating(function($obj) {
          return true;
        });

    }
    
    public static function purge($custID) {

      $model = new CUSTOMER();
      
      $model->where('_id', $custID)->delete();
      
      $model = new Groups();

      $model->where('cust_id', $custID)->delete();
      
      $model = new CarrierInventory();

      $model->where('customer_id', $custID)->delete();
      
      $model = new Provision();

      $model->where('customer_id', $custID)->delete();
      
      $model = new RadioInventory();

      $model->where('customer_id', $custID)->delete();
      
      $model = new Templates();

      $model->where('customer_id', $custID)->delete();
      
      $model = new USER();

      $model->where('cust_id', $custID)->delete();

    }
    
    public function search($pgn=1, $ppg=20, $params=array()) {

      $model = new CUSTOMER();

      if(isset($params['srchCompName']) && trim($params['srchCompName'])!='') {
        $model = $model->where('comp_name', 'like', '%' . $params['srchCompName'] . '%');
      }
      if(isset($params['srchUName']) && trim($params['srchUName'])!='') {
        $model = $model->where('username', 'like', '%' . $params['srchUName'] . '%');
      }
      if(isset($params['srchRUK']) && trim($params['srchRUK'])!='') {
        $model = $model->where('ruk', 'like', '%' . $params['srchRUK'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->paginate($ppg);

    // 	$whr = " (VAR.deleted_at is null or VAR.deleted_at = '') ";

    //   // data filter for ACCREP
    //   $app = App::make('myApp');
    //   if($app->utype == 'ACCREP') $whr .= " and BRD.rep_id = '" . $app->uid . "' ";

    // 	if(isset($params['srchText']) && trim($params['srchText'])!='') {
    // 		$whr .= " and ( ";
    // 		$whr .= " BRD.comp_name like '%".$params['srchText']."%' ";
    //     $whr .= " or VAR.cust_no like '%".$params['srchText']."%' ";
    // 		$whr .= " or BRD.con_email like '%".$params['srchText']."%' ";
    // 		$whr .= " ) ";
    // 	}
    //   if(isset($params['srchCustNo']) && trim($params['srchCustNo'])!='') {
    //     $whr .= " and VAR.cust_no like '%".$params['srchCustNo']."%' ";
    //   }
    // 	if(isset($params['srchCompName']) && trim($params['srchCompName'])!='') {
    // 		$whr .= " and BRD.comp_name like '%".$params['srchCompName']."%' ";
    // 	}
    // 	if(isset($params['srchEmail']) && trim($params['srchEmail'])!='') {
    // 		$whr .= " and BRD.con_email like '%".$params['srchEmail']."%' ";
    // 	}

    //   $sql  = " select VAR.*, BRD.*, CONCAT_WS(' ', BRD.first_name, BRD.last_name) as name, VAR.cust_no as customer_no ";
    //   $sql .= " from tbl_e2et_var VAR left outer join tbl_e2et_acc_onboarding BRD ";
    //   $sql .= " on VAR.var_id = BRD.master_id and VAR.user_type = BRD.master_type ";
    //   $sql .= " where " . $whr . " order by BRD.comp_name, BRD.cust_no limit " . ($pgn - 1) * $ppg . ", " . $ppg;
    // 	$results = DB::select($sql);

    //   $ksql  = " select count(*) as kount from tbl_e2et_var VAR left outer join tbl_e2et_acc_onboarding BRD ";
    //   $ksql .= " on VAR.var_id = BRD.master_id and VAR.user_type = BRD.master_type where " . $whr;
    //   $kresult = DB::select($ksql);
    //   $kount = $kresult[0]->kount;

		  // // creating pagination
		  // $results = Paginator::make($results, $kount, $ppg);

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
                        'password'              => 'between:6,100|confirmed',
                        'password_confirmation' => 'required_with:password|between:6,100',
                        'comp_name'             => 'required|max:100',
                        'con_name'              => 'required|max:100',
                        'con_email'             => 'required|email|max:255',
                        'is_active'             => 'required',
                      ];
          break;

        case 'updatepassword':
          $rules   = [
                        'password'              => 'required|between:6,100|confirmed',
                        'password_confirmation' => 'required|between:6,100',
                      ];
          break;

        case 'updateaccount':
          $rules   = [
                        'comp_name'             => 'required|max:100',
                        'con_name'              => 'required|max:100',
                        'con_email'             => 'required|email|max:255',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'username'              => 'sometimes|required|between:6,100|alpha_num|unique:tbl_customer,username,'.$id.',_id',
                        'password'              => 'required|between:6,100|confirmed',
                        'password_confirmation' => 'required|required_with:password|between:6,100',
                        'comp_name'             => 'required|max:100',
                        'con_name'              => 'required|max:100',
                        'con_email'             => 'required|email|max:255',
                        'is_active'             => 'required',
                      ];
      }

      return $rules;

    }

    public function createaccount() {

      try {
        DB::beginTransaction();

        // saving self
        $this->save();

        // fetching a new RUK
        $ruk = $this->getRUK();

        // saving ruk
        $this->ruk = $ruk;
        $this->save();

      }
      catch(Exception $e) {
        DB::rollback();
        //pr($e->getMessage(), 1);
        return false;
      }
      DB::commit();
      return true;
    }

    public function getRUK() {
      $ruk = '';
      $ruk_length = Config::get('settings.ruk_length');
      $arr = array_merge(range('a', 'z'), range(0, 9));

      do {
        shuffle($arr);
        $ruk = array_slice($arr, 0, $ruk_length);
        $ruk = implode('', $ruk);

        $kount = DB::table('tbl_admin_user')->where('ruk', $ruk)->count();
      } while ($kount > 0);

      return $ruk;
    }

}