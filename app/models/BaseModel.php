<?php

Use Carbon\Carbon as Carbon;

class BaseModel extends Eloquent {

    protected $niceMessages;
    protected $allowedFtrValidations;
    protected $IPTypes;

    function __construct() {
      parent::__construct();

      $this->niceMessages = [
                              'requires'        => ':attribute requires :field.',

                              'lessthan'        => ':attribute should be less than :value.',
                              'greaterthan'     => ':attribute should be greater than :value.',

                              'lessthaneqip'    => 'Last octet should be less than :value.',
                              'greaterthaneqip' => 'Last octet should be greater than :value.',

                              'distinct'        => ':attribute already exists.',
                              'distinctip'      => ':attribute already exists.',
                              'distinctrange'   => ':attribute already exists.',
                              'distinctiprange' => ':attribute already exists.',
                              'allowed'         => 'Invalid rule added. See help.',
                            ];

      $this->allowedFtrValidations = 'distinct-alpha-alpha_num-between-digits-digits_between-email-in-integer-ip-max-min-not_in-numeric-size-url';

      $this->IPTypes = [ 'IP', 'IP Range' ];

    }

    public function scopeIsActive($query) {
      return $query->where('is_active', 'Yes');
    }

    public function populate($data, $withGuarded = true) {

      // populating fillable properties
      $this->fill($data);

      // populating guarded properties if opted for
      if($withGuarded) {
        foreach($this->guarded as $attr) {
          if(isset($data[$attr])) $this->{$attr} = $data[$attr];
        }
      }

      return $this;
    }

    public function setMySQLDateAttr($a, $v) {
      return $v ?  Carbon::createFromFormat('m/d/Y', $v) : null;
    }

    public function getUSDateAttr($v) {
      return $v ? Carbon::createFromFormat('Y-m-d H:i:s', $v)->format('m/d/Y H:i:s') : null;
    }

    protected function getFeatureFieldName($txt='', $pre='') {
    	return getFeatureFieldName($txt, $pre);
        // $fld = preg_replace("/[^a-zA-Z0-9\s_]+/", "", $txt );
        // $fld = str_replace(" ", "_", $fld);
        // $fld = strtolower($fld);

        // return $pre . $fld;
    }

    protected function getCustomerforAdmin() {
      $app = App::make('myApp');

      // if logged user is customer himself
      if($app->utype == 'CUSTOMER') return CUSTOMER::find($app->uid);
      // if logged user is an user with administrator privilege
      else if($app->utype == 'USER' && $app->isCustAdmin) return CUSTOMER::find($app->custAdminID);

      return (new CUSTOMER());
      //return null;
    }

    protected function getTheBoss() {
      $app = App::make('myApp');

      // if logged user is customer himself
      if($app->utype == 'CUSTOMER') return CUSTOMER::find($app->uid);
      // if logged user is an user with administrator privilege
      else if($app->utype == 'USER') return CUSTOMER::find($app->pid);

      return (new CUSTOMER());
      //return null;
    }

}