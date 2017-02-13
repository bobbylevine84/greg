<?php

class CarrierInventory extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_carrier_inventory` (
  `_id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `carrier_id` int(11) NOT NULL DEFAULT '0',
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
    protected $table = 'tbl_carrier_inventory';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [ 'carrier_id', 'model_id', 'sku', 'customer_id' ];
    protected $guarded  = [ '_id' ];
    protected $dates = ['deleted_at'];

    //protected $appends = ['accountrep'];

    // relations
    // Deployment
    public function deployment() {
        return $this->hasOne('ProvisionRadioItemCarrierItem', 'sku', 'sku');
    }

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
                                'carrier_id'  => 'Carrier',
                                'model_id'    => 'Model',
                                'sku'         => 'Serial Number',
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
        return $this->belongsTo('CarrierModel', 'model_id', '_id');
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

      $administrator = $this->getTheBoss();
      //$carriers = $administrator->carriers()->isActive()->get()->lists('carrier_name', '_id');
      $carriermodels = $administrator->carriermodels()->isActive()->get()->lists('model_name', '_id');

      $model = new CarrierInventory();

      $model = $model->join('tbl_carrier', 'tbl_carrier_inventory.carrier_id', '=', 'tbl_carrier._id');
      $model = $model->join('tbl_carrier_model', 'tbl_carrier_inventory.model_id', '=', 'tbl_carrier_model._id');

      $model = $model->select('tbl_carrier_inventory.*', 'tbl_carrier.carrier_name', 'tbl_carrier_model.model_name');
      $model = $model->where('tbl_carrier_inventory.customer_id', $custAdmin );
      $model = $model->whereIn('tbl_carrier_model._id', array_keys($carriermodels));

      // filtering for normal(operator) users
      // showing only those records which they are related to by templates
      if(!$app->isCustAdmin) {
        $cms = [];// container for vendor model ids from templates which user has access to
        $appUser = USER::find($app->uid);// get logged in user

        $uts = $appUser->templates();// get all templates for logged in user

        // loop for each template and get the vendor model id out of it
        if(count($uts)>0) {
          foreach($uts as $t) {
            if($t->carriermodel) $cms[] = $t->carriermodel->_id;
          }
        }

        // filter with the found vendor model id
        $model = $model->whereIn('tbl_carrier_model._id', $cms);
      }


      if(isset($params['srchCICarrier']) && trim($params['srchCICarrier'])!='') {
        $model = $model->where('carrier_id', $params['srchCICarrier'] );
      }
      if(isset($params['srchCIModel']) && trim($params['srchCIModel'])!='') {
        $model = $model->where('model_id', $params['srchCIModel'] );
      }
      if(isset($params['srchCIStatus']) && trim($params['srchCIStatus'])!='') {
        $model = $model->where('status', 'like', '%' . $params['srchCIStatus'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->orderBy('carrier_name', 'asc')->orderBy('model_name', 'asc')->orderBy('sku', 'asc')->paginate($ppg);

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
                        'carrier_id' => 'required',
                        'model_id'   => 'required',
                        'sku'        => 'required|max:100|unique:tbl_carrier_inventory,sku,'.$id.',_id',
                      ];
          break;

        case 'import':
          $rules   = [
                        'carrier_id'  => 'required',
                        'model_id'    => 'required',
                        'import_file' => 'required|max:1030|mimes:txt',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'carrier_id' => 'required',
                        'model_id'   => 'required',
                        'sku'        => 'required|max:100|unique:tbl_carrier_inventory,sku,'.$id.',_id',
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