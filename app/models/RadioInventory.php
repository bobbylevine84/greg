<?php

class RadioInventory extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_radio_inventory` (
  `_id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `model_id` int(11) NOT NULL DEFAULT '0',
  `sku` varchar(100) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Available' COMMENT 'Available/Staged/Deployed',
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
    protected $table = 'tbl_radio_inventory';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 'vendor_id', 'model_id', 'sku', 'guid', 'customer_id' ];
    protected $guarded  = [ '_id' ];
    protected $dates = ['deleted_at'];

    //protected $appends = ['accountrep'];

    // relations
    // Deployment
    public function deployment() {
        return $this->hasOne('ProvisionRadioItem', 'sku', 'sku');
    }

    // relations
    // // users
    // public function users() {
    //     return $this->belongsToMany('USER', 'tbl_group_user', 'group_id', 'user_id');
    // }

    // // Name
    // public function getNameAttribute() {
    //   return $this->attributes['first_name'] . (!empty($this->attributes['first_name']) ? ' ' : '') . $this->attributes['last_name'];
    // }

    // Pretty names for fields
    public static $niceNames = [
                                'vendor_id'   => 'Vendor',
                                'model_id'    => 'Model',
                                'sku'         => 'Serial Number',
                                'guid'        => 'GUID',
                                'import_file' => 'Selected File',
                              ];

    // validation error container
    public $vErrors;

    function __construct() {
      parent::__construct();

      // setting nice mesages
      $this->niceMessages = [
                              'import_file.mimes' => ':attribute should be a text file.',
                              'sku.unique'        => ':attribute already exists.',
                            ];

    }

    // Model
    public function model() {
        return $this->belongsTo('VendorModel', 'model_id', '_id');
    }

    public static function boot() {
        parent::boot();

        // events in order of presedence
        static::saving(function($obj) {
          return true;
        });

        static::creating(function($obj) {
          $app = App::make('myApp');

          $obj->customer_id = $app->custAdminID;
          $obj->status = 'Available';

          return true;
        });

        static::updating(function($obj) {
          return true;
        });

    }

    public function search($pgn=1, $ppg=20, $params=array()) {

      $app = App::make('myApp');
      $custAdmin = $app->pid;

// $appUser = USER::find($app->uid);

// //$vms = $app->user->groups->templates->vendormodel->lists('model_name', '_id');

// $vms = [];

// $uts = $appUser->templates();

// if(count($uts)>0) {
//   foreach($uts as $t) {
//     $vms[] = $t->vendormodel->_id;
//   }
// }

// //$vms = $appUser->templates();

// pr($vms, 1);

      $administrator = $this->getTheBoss();
      //$vendors = $administrator->vendors()->isActive()->get()->lists('vendor_name', '_id');
      $vendormodels = $administrator->vendormodels()->isActive()->get()->lists('model_name', '_id');

      $model = new RadioInventory();

      $model = $model->join('tbl_vendor', 'tbl_radio_inventory.vendor_id', '=', 'tbl_vendor._id');
      $model = $model->join('tbl_vendor_model', 'tbl_radio_inventory.model_id', '=', 'tbl_vendor_model._id');

      $model = $model->select('tbl_radio_inventory.*', 'tbl_vendor.vendor_name', 'tbl_vendor_model.model_name');
      $model = $model->where('tbl_radio_inventory.customer_id', $custAdmin );
      $model = $model->whereIn('tbl_vendor_model._id', array_keys($vendormodels));

      // filtering for normal(operator) users
      // showing only those records which they are related to by templates
      if(!$app->isCustAdmin) {
        $vms = [];// container for vendor model ids from templates which user has access to
        $appUser = USER::find($app->uid);// get logged in user

        $uts = $appUser->templates();// get all templates for logged in user

        // loop for each template and get the vendor model id out of it
        if(count($uts)>0) {
          foreach($uts as $t) {
            $vms[] = $t->vendormodel->_id;
          }
        }

        // filter with the found vendor model id
        $model = $model->whereIn('tbl_vendor_model._id', $vms);
      }

      if(isset($params['srchRIVendor']) && trim($params['srchRIVendor'])!='') {
        $model = $model->where('tbl_vendor._id', $params['srchRIVendor'] );
      }
      if(isset($params['srchRIModel']) && trim($params['srchRIModel'])!='') {
        $model = $model->where('model_id', $params['srchRIModel'] );
      }
      if(isset($params['srchRIStatus']) && trim($params['srchRIStatus'])!='') {
        $model = $model->where('status', 'like', '%' . $params['srchRIStatus'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->orderBy('vendor_name', 'asc')->orderBy('model_name', 'asc')->orderBy('sku', 'asc')->paginate($ppg);

    	return $results;
    }

    public function isValid($case='create', $id=0) {

      $validation = Validator::make($this->attributes, $this->vRules($case, $id), $this->niceMessages);
      //$validation = Validator::make($input, $this->vRules($case, $id));
      $validation->setAttributeNames(static::$niceNames);

      if($validation->passes()) return true;
      $this->vErrors = $validation->messages();

      return false;
    }

    public function isValidImport($input) {

      $validation = Validator::make($input, $this->vRules('import', '0'), $this->niceMessages);
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
                        'vendor_id' => 'required',
                        'model_id'  => 'required',
                        'sku'       => 'required|max:100|unique:tbl_radio_inventory,sku,'.$id.',_id',
                      ];
          break;

        case 'import':
          $rules   = [
                        'vendor_id'   => 'required',
                        'model_id'    => 'required',
                        'import_file' => 'required|max:1030|mimes:txt',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'vendor_id' => 'required',
                        'model_id'  => 'required',
                        'guid'      => 'required_without_all:sku|max:100|unique:tbl_radio_inventory,guid,'.$id.',_id',
                      ];
      }

      return $rules;

    }

    public function saveimport($data=[]) {

      try {

        DB::beginTransaction();

          // looping for each data
          foreach($data as $obj) $obj->save();
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