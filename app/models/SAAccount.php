<?php

class SAAccount extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_admin_user` (
  `user_id` int(11) NOT NULL,
  `rep_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `comp_name` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `con_email` varchar(255) DEFAULT NULL,
  `con_phone` varchar(20) DEFAULT NULL,
  `prod_disc` int(11) NOT NULL DEFAULT '10',
  `radio_disc` int(11) NOT NULL DEFAULT '25',
  `accs_disc` int(11) NOT NULL DEFAULT '15',
  `pay_term` int(11) NOT NULL DEFAULT '15',
  `territory` varchar(150) DEFAULT NULL,
  `is_su` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
*/

    use SoftDeletingTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_admin_user';
    protected $primaryKey = '_id';
    public $incrementing = true;

    public $timestamps = true;

    //protected $fillable = [];
    protected $guarded  = ['password', 'password_confirmation'];
    protected $dates = ['deleted_at'];

    // Pretty names for fields
    public static $niceNames = [
                                'password'              => 'Password',
                                'password_confirmation' => 'Confirm Password',
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
          return true;
        });

        static::updating(function($obj) {
          return true;
        });

    }


    public function isValid($case='create', $id=0) {

      $validation = Validator::make($this->attributes, $this->vRules($case, $id));
      $validation->setAttributeNames(static::$niceNames);

      if($validation->passes()) return true;
      $this->vErrors = $validation->messages();

      return false;
    }

    public function vRules($case='create', $id=0) {
      $rules = [];

      switch($case) {

        case 'updatepassword':
        default:
          $rules   = [
                        'password'              => 'required|between:6,100|confirmed',
                        'password_confirmation' => 'required|between:6,100',
                      ];
      }

      return $rules;

    }

    public function saveaccount() {
      try {
        DB::beginTransaction();

        // saving self
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

}