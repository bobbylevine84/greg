<?php

Use Carbon\Carbon as Carbon;

class ProvisionRadioItem extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_provision_radio_item` (
  `_id` bigint(11) NOT NULL,
  `provision_id` int(11) NOT NULL DEFAULT '0',
  `tmpl_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `sku` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Staged' COMMENT 'Staged/Released/Deployed'
  `deployed_at` timestamp NULL DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

    use SoftDeletingTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_provision_radio_item';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 'provision_id', 'tmpl_id', 'sku', 'status' ];
    protected $guarded  = [ '_id', 'user_id', 'deployed_at' ];
    protected $dates = ['deleted_at', 'deployed_at'];

    // constructor
    function __construct() {
      parent::__construct();

    }

    // relations
    // Template
    public function template() {
        return $this->belongsTo('Templates', 'tmpl_id', '_id');
    }

    // Provision
    public function provision() {
        return $this->belongsTo('Provision', 'provision_id', '_id');
    }

    // Radio Inventory
    public function inventory() {
        return $this->belongsTo('RadioInventory', 'sku', 'sku');
    }

    // Provision Item Features
    public function features() {
        return $this->hasMany('ProvisionRadioItemFeature', 'radio_item_id', '_id');
    }

    // Provision Item Carrier Item
    public function carrieritems() {
        return $this->hasMany('ProvisionRadioItemCarrierItem', 'radio_item_id', '_id');
    }

    // Provision
    public function provisionuser() {
        return $this->belongsTo('USER', 'user_id', '_id');
    }

    // MUTATORS
    public function getDeployedAtAttribute($value) {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('m/d/Y g:i:s A') : null;
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

}