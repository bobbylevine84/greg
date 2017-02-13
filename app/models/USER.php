<?php

class USER extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `_id` int(11) NOT NULL,
  `cust_id` INT NOT NULL DEFAULT '0',
  `user_type` varchar(10) NOT NULL DEFAULT 'USER',
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `ruk` varchar(10) DEFAULT NULL,
  `is_active` varchar(5) NOT NULL DEFAULT 'Yes',
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
    protected $table = 'tbl_user';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 'user_name', 'user_email', 'is_active' ];
    protected $guarded  = [ '_id', 'ruk', 'username', 'password', 'password_confirmation', 'user_type', 'cust_id' ];
    protected $dates = ['deleted_at'];

    //protected $appends = ['accountrep'];

    // relations
    // Groups
    public function groups() {
        return $this->belongsToMany('Groups', 'tbl_group_user', 'user_id', 'group_id');
    }

    // Customer
    public function customer() {
        return $this->belongsTo('CUSTOMER', 'cust_id', '_id');
    }

    // custom method to get user templates
    public function templates($fields=[]) {
      // get the user group ids of authenticated user
      $groups = $this->groups()->isActive()->get()->lists('_id');

      // get the templates of the groups
      $templates = Templates::whereHas('groups', function($q) use($groups) {
        $q->whereIn('group_id', $groups);
      })->isActive();

      if(is_array($fields) && count($fields)>0) $templates = $templates->get($fields);
      else $templates = $templates->get();

      return $templates;
    }

    // Pretty names for fields
    public static $niceNames = [
                                'user_name'             => 'Name',
                                'user_email'            => 'Email',
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
          $app = App::make('myApp');

          $obj->cust_id = $app->custAdminID;
          $obj->ruk     = $app->RUK;

          $obj->user_type = 'USER';

          return true;
        });

        static::updating(function($obj) {
          return true;
        });

    }

    public function search($pgn=1, $ppg=20, $params=array()) {

      $app = App::make('myApp');

      $model = new USER();
      $model = $model->leftJoin('tbl_group_user', 'tbl_group_user.user_id', '=', 'tbl_user._id');
      $model = $model->leftJoin('tbl_group', 'tbl_group._id', '=', 'tbl_group_user.group_id');

      //$model = $model->select('tbl_user.*', DB::raw('GROUP_CONCAT(DISTINCT tbl_group.group_name ORDER BY tbl_group.group_name) as user_groups'));
      $model = $model->select('tbl_user.*');

      $model = $model->where('tbl_user.cust_id', $app->custAdminID);

      if(isset($params['srchName']) && trim($params['srchName'])!='') {
        $model = $model->where('tbl_user.user_name', 'like', '%' . $params['srchName'] . '%');
      }
      if(isset($params['srchUName']) && trim($params['srchUName'])!='') {
        $model = $model->where('tbl_user.username', 'like', '%' . $params['srchUName'] . '%');
      }
      if(isset($params['srchGrp']) && trim($params['srchGrp'])!='') {
        $model = $model->where('group_name', 'like', '%' . $params['srchGrp'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->groupBy('tbl_user._id')->paginate($ppg);

    	return $results;
    }

    public function isValid($input, $case='create', $id=0) {

      //$validation = Validator::make($this->attributes, $this->vRules($case, $id));
      $validation = Validator::make($input, $this->vRules($case, $id));
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
                        'user_name'             => 'required|max:100',
                        'user_email'            => 'required|email|max:255',
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
                        'user_name'             => 'required|max:100',
                        'user_email'            => 'required|email|max:255',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'username'              => 'sometimes|required|between:6,100|alpha_num|unique:tbl_user,username,'.$id.',_id',
                        'password'              => 'required|between:6,100|confirmed',
                        'password_confirmation' => 'required|required_with:password|between:6,100',
                        'user_name'             => 'required|max:100',
                        'user_email'            => 'required|email|max:255',
                        'is_active'             => 'required',
                      ];
      }

      return $rules;

    }

    public function saveuser($input, $case='create') {

      $this->populate($input);

      try {
        DB::beginTransaction();

        // saving self
        $this->save();

        // // creating RUK for new user
        // if($case=='create') {
        //   // fetching a new RUK
        //   $ruk = $this->getRUK();

        //   // saving ruk
        //   $this->ruk = $ruk;
        //   $this->save();
        // }

        $this->groups()->sync(Input::get('group_ids', []));

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

        $kount = DB::table('tbl_user')->where('ruk', $ruk)->count();
      } while ($kount > 0);

      return $ruk;
    }

}