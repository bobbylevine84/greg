<?php

class Groups extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_group` (
  `_id` int(11) NOT NULL,
  `cust_id` INT NOT NULL DEFAULT '0',
  `group_name` varchar(100) DEFAULT NULL,
  `is_active` varchar(5) NOT NULL DEFAULT 'Yes',
  `is_admin` varchar(5) NOT NULL DEFAULT 'No',
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
    protected $table = 'tbl_group';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 'group_name', 'is_active', 'is_admin', 'cust_id' ];
    protected $guarded  = [ '_id' ];
    protected $dates = ['deleted_at'];

    //protected $appends = ['accountrep'];

    // relations
    // Customer
    public function customer() {
        return $this->belongsTo('CUSTOMER', 'cust_id', '_id');
    }

    // users
    public function users() {
        return $this->belongsToMany('USER', 'tbl_group_user', 'group_id', 'user_id');
    }

    // templates
    public function templates() {
        return $this->belongsToMany('Templates', 'tbl_group_template', 'group_id', 'tmpl_id');
    }

    // // Name
    // public function getNameAttribute() {
    //   return $this->attributes['first_name'] . (!empty($this->attributes['first_name']) ? ' ' : '') . $this->attributes['last_name'];
    // }

    // Pretty names for fields
    public static $niceNames = [
                                'group_name'  => 'Group Name',
                                'is_active'   => 'Active',
                                'is_admin'    => 'Administrator',
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
          $app = App::make('myApp');

          if($app->utype == 'CUSTOMER') $obj->cust_id = $app->custAdminID;
          elseif($app->utype == 'USER') $obj->cust_id = $app->custAdminID;

          return true;
        });

        static::updating(function($obj) {
          return true;
        });

    }

    public function search($pgn=1, $ppg=20, $params=array()) {

      $app = App::make('myApp');

      $model = new Groups();

      $model = $model->where('cust_id', $app->custAdminID);

      if(isset($params['srchGName']) && trim($params['srchGName'])!='') {
        $model = $model->where('group_name', 'like', '%' . $params['srchGName'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->orderBy('group_name', 'asc')->paginate($ppg);

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
                        'group_name'  => 'required|max:100',
                        'is_active'   => 'required',
                        'is_admin'    => 'required',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'group_name'  => 'required|max:100',
                        'is_active'   => 'required',
                        'is_admin'    => 'required',
                      ];
      }

      return $rules;

    }

}