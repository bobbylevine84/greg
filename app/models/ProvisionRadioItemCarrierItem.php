<?php

class ProvisionRadioItemCarrierItem extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_provision_radio_item_carrier_item` (
  `_id` bigint(11) NOT NULL,
  `provision_id` int(11) NOT NULL DEFAULT '0',
  `radio_item_id` bigint(11) NOT NULL DEFAULT '0',
  `sku` varchar(100) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Staged' COMMENT 'Staged/Released/Deployed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

    //use SoftDeletingTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_provision_radio_item_carrier_item';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [ 'radio_item_id', 'sku', 'provision_id', 'status' ];
    protected $guarded  = [ '_id' ];
    //protected $dates = ['deleted_at'];

    // constructor
    function __construct() {
      parent::__construct();

    }

    // relations
    // Provision Radio Item
    public function radioitem() {
        return $this->belongsTo('ProvisionRadioItem', 'radio_item_id', '_id');
    }

    // Carrier Inventory
    public function inventory() {
        return $this->belongsTo('RadioInventory', 'sku', 'sku');
    }

    // Provision Radio Item Carrier Item Feature
    public function features() {
        return $this->hasMany('ProvisionRadioItemCarrierItemFeature', 'carrier_item_id', '_id');
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