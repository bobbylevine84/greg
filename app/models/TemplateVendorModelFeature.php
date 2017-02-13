<?php

class TemplateVendorModelFeature extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_template_vendor_model_feature` (
  `_id` int(11) NOT NULL,
  `tmpl_id` int(11) NOT NULL DEFAULT '0',
  `ft_id` int(11) NOT NULL DEFAULT '0',
  `ft_group_id` int(11) NOT NULL DEFAULT '0',
  `ft_label` varchar(100) DEFAULT NULL,
  `ft_type` varchar(20) NOT NULL DEFAULT 'Text-box' COMMENT 'Label/Text-box/Text-area/Drop-down/Range/IP/IP Range',
  `ft_validation` varchar(1000) DEFAULT NULL,
  `ft_values` varchar(1000) DEFAULT NULL,
  `is_active` varchar(5) NOT NULL DEFAULT 'Yes',
  `ft_level` int(11) NOT NULL DEFAULT '1',
  `ft_disp_order` int(11) NOT NULL DEFAULT '1',
  `ft_fld_name` varchar(100) DEFAULT NULL,
  `ft_data_type` varchar(15) NOT NULL DEFAULT 'Text',
  `ft_value_assigned_by` varchar(20) NOT NULL DEFAULT 'Provisioner',
  `ft_decs` tinyint(4) NOT NULL DEFAULT '0',
  `varvalue` varchar(100) DEFAULT NULL,
  `varvalue2` varchar(100) DEFAULT NULL,
  `decvalue` decimal(25,10) NOT NULL DEFAULT '0.0000000000',
  `decvalue2` decimal(25,10) NOT NULL DEFAULT '0.0000000000',
  `txtvalue` text DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

    //use SoftDeletingTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_template_vendor_model_feature';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
                            'ft_id', 'ft_group_id', 'ft_label', 'ft_type', 'ft_validation', 'ft_values', 'is_active', 
                            'ft_data_type', 'ft_level', 'ft_disp_order', 'ft_fld_name', 'varvalue', 'varvalue2', 
                            'decvalue', 'decvalue2', 'txtvalue', 'ft_value_assigned_by', 'ft_decs'
                          ];
    protected $guarded  = [ '_id', 'tmpl_id' ];
    //protected $dates = ['deleted_at'];

    // // custom properties
    // protected $IPTypes;

    // constructor
    function __construct() {
      parent::__construct();
    }

    // query scope for only level 1 features
    public function scopeIsLevel1($query) {
      return $query->where('ft_level', '1');
    }

    // Mutators
    protected function getDecvalueAttribute($value) {
      //return $value && ( in_array($this->ft_type, $this->IPTypes) ) ? long2ip($value) : $value;
      $val = $value && ( in_array($this->ft_type, $this->IPTypes) ) ? long2ip($value) : $value;
      if($val && is_numeric($val)) {
        $val = number_format($val, $this->ft_decs, '.', '');
      }
      return $val;
    }

    protected function setDecvalueAttribute($value) {
      return $value && ( in_array($this->ft_type, $this->IPTypes) ) ? sprintf("%u", ip2long($value)) : $value;
    }

    protected function getDecvalue2Attribute($value) {
      //return $value && ( in_array($this->ft_type, $this->IPTypes) ) ? long2ip($value) : $value;
      $val = $value && ( in_array($this->ft_type, $this->IPTypes) ) ? long2ip($value) : $value;
      if($val && is_numeric($val)) {
        $val = number_format($val, $this->ft_decs, '.', '');
      }
      return $val;
    }

    protected function setDecvalue2Attribute($value) {
      //$val = $value && filter_var($value, FILTER_VALIDATE_IP) !== false ? sprintf("%u", ip2long($value)) : $value;
      return $value && ( in_array($this->ft_type, $this->IPTypes) ) ? sprintf("%u", ip2long($value)) : $value;
    }


    // relations
    // Template
    public function template() {
        return $this->belongsTo('Templates', 'tmpl_id', '_id');
    }

    // Template
    public function feature() {
        return $this->belongsTo('VendorModelFeature', 'ft_id', '_id');
    }

    // Get Parent
    public function parent() {
        return TemplateVendorModelFeature::where('ft_id', $this->ft_group_id )->where('tmpl_id', $this->tmpl_id)->get();
    }

    // Get Children
    public function children($onlyActive=true) {
        $children = TemplateVendorModelFeature::where( 'ft_group_id', $this->ft_group_id )
                                                  ->where('tmpl_id', $this->tmpl_id)
                                                  ->where('ft_level', '>', '1');

        if($onlyActive) $children = $children->isActive();

        return $children->orderBy('ft_disp_order', 'asc')->get();
    }

    public function hasChildren($onlyActive=true) {
        return !$this->children($onlyActive)->isEmpty();
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