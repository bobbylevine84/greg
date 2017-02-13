<?php

class ProvisionRadioItemCarrierItemFeature extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_provision_radio_item_carrier_item_feature` (
  `_id` int(11) NOT NULL,
  `provision_id` int(11) NOT NULL DEFAULT '0',
  `carrier_item_id` int(11) NOT NULL DEFAULT '0',
  `tmpl_id` int(11) NOT NULL DEFAULT '0',
  `ft_fld_name` varchar(100) DEFAULT NULL,
  `ft_fld_value` varchar(100) DEFAULT NULL,
  `ft_is_ip` varchar(5) NOT NULL DEFAULT 'No',
  `ft_value_assigned_by` varchar(20) NOT NULL DEFAULT 'Provisioner',
  `status` varchar(15) NOT NULL DEFAULT 'Staged' COMMENT 'Staged/Released/Deployed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

    //use SoftDeletingTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_provision_radio_item_carrier_item_feature';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [ 
                            'carrier_item_id', 'ft_fld_name', 'ft_fld_value', 'tmpl_id', 'provision_id', 'status', 
                            'ft_is_ip', 'ft_value_assigned_by', 
                          ];
    protected $guarded  = [ '_id' ];
    //protected $dates = ['deleted_at'];

    // constructor
    function __construct() {
      parent::__construct();

    }

    // Mutators
    protected function getFtFldValueAttribute($value) {
      // return $value && filter_var($value, FILTER_VALIDATE_IP) !== false ? long2ip($value) : $value;
      return $value && $this->ft_is_ip == 'Yes' ? long2ip($value) : $value;
    }

    protected function setFtFldValueAttribute($value) {
      return $value && filter_var($value, FILTER_VALIDATE_IP) !== false ? sprintf("%u", ip2long($value)) : $value;
      // return $value && $this->ft_is_ip == 'Yes' ? sprintf("%u", ip2long($value)) : $value;
    }

    // relations
    // Provision Carrier Item
    public function radioitem() {
        return $this->belongsTo('ProvisionRadioItemCarrierItem', 'carrier_item_id', '_id');
    }

    // Vendor Model Feature
    public function carriermodelfeature() {
        return $this->belongsTo('CarrierModelFeature', 'ft_fld_name', 'ft_fld_name');
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