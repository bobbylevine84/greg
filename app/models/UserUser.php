<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserUser extends BaseModel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table;
	protected $primaryKey;

	function __construct() {
		parent::__construct();

		$this->table = 'tbl_user';
		$this->primaryKey = '_id';
	}


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $guarded = [];//array('user_id', 'username', 'password');
	public $timestamps = false;

    // relations
    public function groups() {
        return $this->belongsToMany('Groups', 'tbl_group_user', 'user_id', 'group_id');
    }

    // Parent Customer
    public function parent() {
        return $this->belongsTo('CUSTOMER', 'cust_id', '_id');
    }

    public function isAdmin() {

    	$admingroups = $this->groups()->isActive()->where('is_admin', 'Yes')->count();

    	return $admingroups > 0;
    }

    public function adminID() {
    	if(!$this->isAdmin()) return 0;
    	return $this->parent->_id;
    }

}
