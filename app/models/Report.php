<?php

class Report extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_report` (
  `_id` bigint(20) NOT NULL,
  `report_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

    use SoftDeletingTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_report';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [ 'report_name' ];
    protected $guarded  = [ '_id' ];
    //protected $dates = ['deleted_at'];

    //protected $appends = ['accountrep'];

    function __construct() {
      parent::__construct();

    }

    public static function boot() {
        parent::boot();

        // events in order of presedence
        static::saving(function($obj) {
          return false;
        });

        static::creating(function($obj) {
          return false;
        });

        static::updating(function($obj) {
          return false;
        });

    }

    public function searchRadioInventory($pgn=1, $ppg=20, $params=array()) {

      $app = App::make('myApp');
      $custAdmin = $app->pid;

      $administrator = $this->getTheBoss();
      // $vendors = $administrator->vendors()->isActive()->get()->lists('vendor_name', '_id');
      $vendormodels = $administrator->vendormodels()->isActive()->get()->lists('model_name', '_id');

      $model = new RadioInventory();

      $model = $model->join('tbl_vendor', 'tbl_radio_inventory.vendor_id', '=', 'tbl_vendor._id');
      $model = $model->join('tbl_vendor_model', 'tbl_radio_inventory.model_id', '=', 'tbl_vendor_model._id');

      $model = $model->select('tbl_radio_inventory.*', 'tbl_vendor.vendor_name', 'tbl_vendor_model.model_name');
      $model = $model->where('tbl_radio_inventory.customer_id', $custAdmin );
      $model = $model->whereIn('tbl_vendor._id', array_keys($vendormodels));

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
        $model = $model->where('vendor_id', $params['srchRIVendor'] );
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

    public function searchCarrierInv($pgn=1, $ppg=20, $params=array()) {

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
      $model = $model->whereIn('tbl_carrier._id', array_keys($carriermodels));

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

    public function searchGroups($pgn=1, $ppg=20, $params=array()) {

      $app = App::make('myApp');

      $model = new Groups();

      $model = $model->where('cust_id', $app->custAdminID);

      if(isset($params['srchGName']) && trim($params['srchGName'])!='') {
        $model = $model->where('group_name', 'like', '%' . $params['srchGName'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->orderBy('group_name', 'asc')->paginate($ppg);

      return $results;
    }

    public function searchUser($pgn=1, $ppg=20, $params=array()) {

      $app = App::make('myApp');

      $model = new USER();

      $model = $model->where('cust_id', $app->custAdminID);

      if(isset($params['srchName']) && trim($params['srchName'])!='') {
        $model = $model->where('user_name', 'like', '%' . $params['srchName'] . '%');
      }
      if(isset($params['srchUName']) && trim($params['srchUName'])!='') {
        $model = $model->where('username', 'like', '%' . $params['srchUName'] . '%');
      }
      if(isset($params['srchRUK']) && trim($params['srchRUK'])!='') {
        $model = $model->where('ruk', 'like', '%' . $params['srchRUK'] . '%');
      }

      // ordering
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->paginate($ppg);

      return $results;
    }


    public function deploymentscomplete($pgn=1, $ppg=20, $params=array()) {

      $app = App::make('myApp');

      $model = new Provision();
      $model = $model->where('tbl_provision.customer_id', $app->pid);
      $model = $model->where('tbl_provision.is_archieved', 'No');

      $model = $model->join('tbl_template', 'tbl_provision.tmpl_id', '=', 'tbl_template._id');
      $model = $model->join('tbl_vendor', 'tbl_provision.vendor_id', '=', 'tbl_vendor._id');
      $model = $model->join('tbl_vendor_model', 'tbl_provision.vendor_model_id', '=', 'tbl_vendor_model._id');

      $model = $model->select('tbl_provision.*', 'tbl_template.tmpl_name', 'tbl_vendor.vendor_name', 'tbl_vendor_model.model_name');

      // filtering for normal(operator) users
      // showing only those records which they are related to
      if(!$app->isCustAdmin) {
        $tmps = [];// container for templates which user has access to
        $appUser = USER::find($app->uid);// get logged in user

        $uts = $appUser->templates();// get all templates for logged in user

        // loop for each template and get the id out of it
        if(count($uts)>0) {
          foreach($uts as $t) {
            $tmps[] = $t->_id;
          }
        }

        // filter with the found vendor model id
        $model = $model->whereIn('tbl_provision.tmpl_id', $tmps);
      }

      if(isset($params['srchTName']) && trim($params['srchTName'])!='') {
        $model = $model->where('tmpl_name', 'like', '%' . $params['srchTName'] . '%');
      }
      if(isset($params['srchVName']) && trim($params['srchVName'])!='') {
        $model = $model->where('vendor_name', 'like', '%' . $params['srchVName'] . '%');
      }
      if(isset($params['srchMName']) && trim($params['srchMName'])!='') {
        $model = $model->where('model_name', 'like', '%' . $params['srchMName'] . '%');
      }

      // ordering
      $model = $model->orderBy('tbl_provision.status', 'desc');
      if(isset($params['srchOBy']) && trim($params['srchOBy'])!='') {
        $ord_type = isset($params['srchOTp']) && trim($params['srchOTp'])!='' ? $params['srchOTp'] : 'asc';

        $model = $model->orderBy($params['srchOBy'], $ord_type);
      }

      $results = $model->orderBy('tbl_provision.created_at', 'asc')->orderBy('tmpl_name', 'asc')->paginate($ppg);

      return $results;
    }


}