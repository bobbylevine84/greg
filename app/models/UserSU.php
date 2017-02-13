<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserSU extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table;
	protected $primaryKey;

	function __construct() {
		parent::__construct();

		$this->table = 'tbl_admin_user';
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
    // public function onboarding() {
    //     //return $this->hasOne('OnBoarding', 'user_id', 'user_id');
    //     return $this->morphOne('OnBoarding', 'master');
    // }

}
