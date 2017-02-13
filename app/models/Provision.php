<?php

Use Carbon\Carbon as Carbon;

class Provision extends BaseModel {

/*
CREATE TABLE IF NOT EXISTS `tbl_provision` (
  `_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `tmpl_id` int(11) NOT NULL DEFAULT '0',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `vendor_model_id` int(11) NOT NULL DEFAULT '0',
  `carrier_id` int(11) NOT NULL DEFAULT '0',
  `carrier_model_id` int(11) NOT NULL DEFAULT '0',
  `cards_per_radio` int(11) NOT NULL DEFAULT '1',
  `no_of_deploy` int(11) NOT NULL DEFAULT '0',
  `is_active` varchar(5) NOT NULL DEFAULT 'Yes',
  `is_archieved` varchar(5) NOT NULL DEFAULT 'No',
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
    protected $table = 'tbl_provision';
    protected $primaryKey = '_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
                            'customer_id', 'tmpl_id', 'vendor_id', 'vendor_model_id', 'carrier_id', 'carrier_model_id', 
                            'cards_per_radio', 'no_of_deploy', 'is_active', 'is_archieved'
                          ];
    protected $guarded  = [ '_id' ];
    protected $dates = ['deleted_at'];

    // custom properties
    protected $niceNames;

    //protected $appends = ['accountrep'];

    // relations
    // Customer
    public function customer() {
        return $this->belongsTo('CUSTOMER', 'customer_id', '_id')->withTrashed();
    }

    // Template
    public function template() {
        return $this->belongsTo('Templates', 'tmpl_id', '_id')->withTrashed();
    }

    // Vendor
    public function vendor() {
        return $this->belongsTo('Vendors', 'vendor_id', '_id')->withTrashed();
    }

    // Vendor Model
    public function vendormodel() {
        return $this->belongsTo('VendorModel', 'vendor_model_id', '_id')->withTrashed();
    }

    // Carrier
    public function carrier() {
        return $this->belongsTo('Carrier', 'carrier_id', '_id')->withTrashed();
    }

    // Carrier Model
    public function carriermodel() {
        return $this->belongsTo('CarrierModel', 'carrier_model_id', '_id')->withTrashed();
    }

    // Provision Radio Items
    public function items() {
        return $this->hasMany('ProvisionRadioItem', 'provision_id', '_id');
    }

    // Provision Staged Radio Items
    public function stageditems() {
        return ProvisionRadioItem::where('provision_id', $this->_id)->where('status', 'Staged');
    }

    // Provision Deployed Radio Items
    public function deployeditems() {
        return ProvisionRadioItem::where('provision_id', $this->_id)->where('status', 'Deployed');
    }

    // Provision Staged Radio Items
    public function releaseditems() {
        return ProvisionRadioItem::where('provision_id', $this->_id)->where('status', 'Released');
    }


    // validation error container
    public $vErrors;

    function __construct() {
      parent::__construct();

      // Pretty names for fields
      $this->niceNames = [
                            'tmpl_id'          => 'Template',
                            'vendor_id'        => 'Vendor',
                            'vendor_model_id'  => 'Vendor Model',
                            'carrier_id'       => 'Carrier',
                            'carrier_model_id' => 'Carrier Model',
                            'no_of_deploy'     => 'Number of Deployments',
                            'is_active'        => 'Active',
                          ];

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

    public function search($pgn=1, $ppg=20, $params=array()) {

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

    public function isValid($input, $case='create', $id=0) {

      //$validation = Validator::make($this->attributes, $this->vRules($case, $id));
      $validation = Validator::make($input, $this->vRules($case, $id), $this->niceMessages);
      $validation->setAttributeNames($this->niceNames);

      if($validation->passes()) return true;
      $this->vErrors = $validation->messages();

      return false;
    }

    public function vRules($case='create', $id=0) {

      $rules = [];

      switch($case) {

        case 'update':
          $rules   = [
                        'tmpl_id'          => 'required',
                        'vendor_id'        => 'required',
                        'vendor_model_id'  => 'required',
                        //'carrier_id'       => 'required',
                        'carrier_model_id' => 'required_with:carrier_id',
                        'no_of_deploy'     => 'required|numeric|min:1',
                        'is_active'        => 'required',
                      ];
          break;

        case 'create':
        default:
          $rules   = [
                        'tmpl_id'          => 'required',
                        'vendor_id'        => 'required',
                        'vendor_model_id'  => 'required',
                        //'carrier_id'       => 'required',
                        'carrier_model_id' => 'required_with:carrier_id',
                        'no_of_deploy'     => 'required|numeric|min:1',
                        'is_active'        => 'required',
                      ];
      }

      return $rules;
    }


    public function saveprovision($input=[]) {

      $radioInv = $carrierInv = $vmf = $cmf = [];
      $radioInvExistsCount = $carrierInvExistsCount = $custAdmin = 0;

      try {

        DB::beginTransaction();

        $this->populate($input);
        $this->status = 'Staged';
        $this->save();

        $needvendorsno = $this->template->needvendorsno();
        $needcarriersno = $this->template->needcarriersno();

        // getting vendor model features for the template
        $vmfs = $this->template->vendormodelfeatures()->where('ft_type', '<>', 'Label')->get()->toArray();

        // getting carrier model features for the template
        $cmfs = $this->template->carriermodelfeatures()->where('ft_type', '<>', 'Label')->get()->toArray();

        // provision radio item, one each for number of deployments
        for($rik=0; $rik<$this->no_of_deploy; $rik++) {
            // fetch an available SKU for the customer
            $app = App::make('myApp');
            $custAdmin = $app->custAdminID;

            $sku = null;
            if($needvendorsno) {
              $sku = RadioInventory::where('customer_id', $custAdmin)
                                      ->where('model_id', $this->vendor_model_id)
                                      ->where('status', 'Available')
                                      ->whereNotIn('sku', $radioInv)
                                      ->pluck('sku');
            }

            // create and save a radio item
            $radioItem = [];
            $radioItem['provision_id'] = $this->_id;
            $radioItem['tmpl_id']      = $this->tmpl_id;
            $radioItem['sku']          = $sku;
            $radioItem['status']       = 'Staged';

            $mRadioItem = new ProvisionRadioItem();
            $mRadioItem->populate($radioItem);
            $mRadioItem->save();

            // inventory would be marked as Staged in a batch
            // after finally checking if the inventories are all available
            // both for radio and also for carrier if applicable
            // so skus are collected in a bag to update status
            $radioInv[] = $sku;

            // now radio item is saved and we need to save its properties/features 
            // CHECK IF RADIO FEATURES APPLICABLE
            if(is_array($vmfs) && count($vmfs) > 0) {
              // looping for all vendor model properties of the selected template
              foreach($vmfs as $vmf) {
                $radioItemFtr = [];
                $radioItemFtr['provision_id']  = $this->_id;
                $radioItemFtr['radio_item_id'] = $mRadioItem->_id;
                $radioItemFtr['tmpl_id']       = $this->tmpl_id;
                $radioItemFtr['ft_fld_name']   = $vmf['ft_fld_name'];
                $radioItemFtr['ft_fld_value']  = $this->getMFValue($vmf, 'Radio');
                $radioItemFtr['ft_is_ip']      = in_array($vmf['ft_type'], $this->IPTypes) ? 'Yes' : 'No';
                $radioItemFtr['status']        = 'Staged';
                $radioItemFtr['ft_value_assigned_by'] = $vmf['ft_value_assigned_by'];

                $mRadioItemFtr = new ProvisionRadioItemFeature();
                $mRadioItemFtr->populate($radioItemFtr);

                $mRadioItemFtr->save();
              }// ./ loop for vendor model features
            }// ./ CHECK IF RADIO FEATURES APPLICABLE

            // radio item features are saved
            // now need to save carrier items if applicable in template
            if($this->carrier_id) {

              // looping for no of carrier items needed per radio
              for($cik=0; $cik<$this->cards_per_radio; $cik++) {

                // fetch an available SKU for the customer
                $sku = null;
                if($needcarriersno) {
                  $sku = CarrierInventory::where('customer_id', $custAdmin)
                                          ->where('model_id', $this->carrier_model_id)
                                          ->where('status', 'Available')
                                          ->whereNotIn('sku', $carrierInv)
                                          ->pluck('sku');
                }

                // create and save a carrier item
                $carrierItem = [];
                $carrierItem['provision_id']  = $this->_id;
                $carrierItem['radio_item_id'] = $mRadioItem->_id;
                $carrierItem['sku']           = $sku;
                $carrierItem['status']        = 'Staged';

                $mCarrierItem = new ProvisionRadioItemCarrierItem();
                $mCarrierItem->populate($carrierItem);
                $mCarrierItem->save();

                // inventory would be marked as Staged in a batch
                // after finally checking if the inventories are all available
                // both for radio and also for carrier if applicable
                // so skus are collected in a bag to update status
                $carrierInv[] = $sku;

                // add carrier features
                // now radio item is saved and we need to save its properties/features
                // CHECK IF CARRIER FEATURES APPLICABLE
                if(is_array($cmfs) && count($cmfs) > 0) {
                  // looping for all vendor model properties of the selected template
                  foreach($cmfs as $cmf) {
                    $carrierItemFtr = [];
                    $carrierItemFtr['provision_id']    = $this->_id;
                    $carrierItemFtr['carrier_item_id'] = $mCarrierItem->_id;
                    $carrierItemFtr['tmpl_id']         = $this->tmpl_id;
                    $carrierItemFtr['ft_fld_name']     = $cmf['ft_fld_name'];
                    $carrierItemFtr['ft_fld_value']    = $this->getMFValue($cmf, 'Carrier');
                    $carrierItemFtr['ft_is_ip']        = in_array($cmf['ft_type'], $this->IPTypes) ? 'Yes' : 'No';
                    $carrierItemFtr['status']          = 'Staged';
                    $carrierItemFtr['ft_value_assigned_by'] = $cmf['ft_value_assigned_by'];

                    $mCarrierItemFtr = new ProvisionRadioItemCarrierItemFeature();
                    $mCarrierItemFtr->populate($carrierItemFtr);
                    $mCarrierItemFtr->save();
                  }// ./ loop for carrier model features
                }// ./ CHECK IF CARRIER FEATURES APPLICABLE
              }// ./ loop for no of carriers per radio
            }// ./ check if carrier needed
        }// ./ loop for number of deployments

        // check if all radio skus are still Available in inventory
        // if yes the mark them staged in inventory
        // else throw exception
        // checking radio items
        if($needvendorsno) {
          $radioInvExistsCount = RadioInventory::whereIn('sku', $radioInv)->where('status', '<>', 'Available')->count();
          if($radioInvExistsCount > 0) {
            $error = 'Radio inventory overlapping. Please try again after some time.';
            throw new RangeException($error);
          }
        }

        // checking carrier item skus
        if($needcarriersno) {
          if($this->carrier_id) $carrierInvExistsCount = CarrierInventory::whereIn('sku', $carrierInv)->where('status', '<>', 'Available')->count();
          if($carrierInvExistsCount > 0) {
            $error = 'Carrier inventory overlapping. Please try again after some time.';
            throw new RangeException($error);
          }
        }

        // it makes sense to get rid of nonsense
        $radioInv = array_filter($radioInv);
        $carrierInv = array_filter($carrierInv);

        // updating inventory
        if(count($radioInv)>0) RadioInventory::whereIn('sku', $radioInv)->update( [ 'status' => 'Staged' ] );
        if(count($carrierInv)>0) CarrierInventory::whereIn('sku', $carrierInv)->update( [ 'status' => 'Staged' ] );

        // provision saved and all work done - happys endings

        // DB::rollback();
        // pr('rolled back :)', 1);
      }
      catch(RangeException $e) {
        DB::rollback();
        //pr($e->getMessage(), 1);
        return $e->getMessage();
      }
      catch(Exception $e) {
        DB::rollback();
        // echo 'D2';
        // pr($e->getTraceAsString(), 1);
        return false;
      }
      DB::commit();
      return true;
    }

    protected function getMFValue($mf=[], $type='Radio') {

      $ret = '';// setting a default return value

      if(count($mf)<=0) return $ret;

      // if value assigned by is Radio Admin then ignore
      if($mf['ft_value_assigned_by'] == 'Radio Admin') return $ret;

      // checking field type of feature and then its data type
      // Text-box/Text-area/Drop-down/Range/IP/IP Range
      // if incrementing then get the next value
      // if numeric then get value from numeric field and assign the same
      // if text then get the value from the text field and assign the same
      switch($mf['ft_type']) {

        // for Text-area
        case 'Text-area':
          $ret = $mf['txtvalue'];
          // $ret = 'SS';
          break;

        // for IP
        case 'IP':
          // IP is always saved in decvalue so no need to check other fields
          // if its incrementing then get the next value for the field for the template
          // else return the value of decvalue field
          if($mf['ft_data_type'] == 'Incrementing') $ret = $this->getMFNextVal($mf, $type);
          else $ret = $mf['decvalue'];

          break;

        // for IP Range
        case 'IP Range':
          $ret = $this->getMFNextVal($mf, $type);

          break;

        // for Range
        case 'Range':
          $ret = $this->getMFNextVal($mf, $type);

          if($ret && is_numeric($ret)) {
            $ret = number_format($ret, $mf['ft_decs'], '.', '');
          }

          break;

        // for Text-box
        case 'Text-box':
        // for Drop-down
        case 'Drop-down':
        default:
          $ret = $mf['ft_data_type'] == 'Text' ? $mf['varvalue'] : number_format($mf['decvalue'], $mf['ft_decs'], '.', '');
          break;
      }

      return $ret;
    }

    protected function getMFNextVal($mf, $type='Radio' ) {

      $nextVal = $start = '';
      $vals = [];

      // getting max values
      if($type=='Radio') {
        $vals = ProvisionRadioItemFeature::where('tmpl_id', $mf['tmpl_id'])
                                             ->where('ft_fld_name', $mf['ft_fld_name'])
                                             ->where('status', '<>', 'Released')
                                             ->get()
                                             ->lists('ft_fld_value');
      }
      else if($type=='Carrier') {
        $vals = ProvisionRadioItemCarrierItemFeature::where('tmpl_id', $mf['tmpl_id'])
                                             ->where('ft_fld_name', $mf['ft_fld_name'])
                                             ->where('status', '<>', 'Released')
                                             ->get()
                                             ->lists('ft_fld_value');
      }

// pr('----------------');
// echo 'Initial Vals ';
// pr($vals);

      // getting start and end limits
      // checking for Range
      if($mf['ft_type'] == 'Range') {
        $start = $mf['ft_data_type'] == 'Text' ? ord($mf['varvalue']) : $mf['decvalue'];
        $end   = $mf['ft_data_type'] == 'Text' ? ord($mf['varvalue2']) : $mf['decvalue2'];
      }

      // checking for IP Range
      if($mf['ft_type'] == 'IP Range') {
        $start = sprintf("%u", ip2long($mf['decvalue']));
        $end   = sprintf("%u", ip2long($mf['decvalue2']));
        array_walk($vals, 'iptono');
      }

      // checking for IP
      if($mf['ft_type'] == 'IP') {
        $start = sprintf("%u", ip2long($mf['decvalue']));
        array_walk($vals, 'iptono');
      }

      // if none of the above type
      // then select a default start value
      if(empty($start)) {
        $start = $mf['ft_data_type'] == 'Text' ? 65 : 1;
      }


// echo 'Modified Vals ';
// pr($vals);

      $maxval = @max($vals);

// echo 'First Maxval ';
// pr($maxval);

      if($maxval && !empty($maxval)) {
        // // checking for IP type
        // if($mf['ft_type'] == 'IP' || $mf['ft_type'] == 'IP Range') $maxval = sprintf("%u", ip2long($maxval));

        // // checking for Text type
        // if($mf['ft_data_type'] == 'Text') $maxval = ord($maxval);
      }
      else $maxval = $start - 1;

      $nextVal = $maxval + 1;

      $start = $start + 0;
      $end = $end + 0;

// echo 'Start ';
// pr($start);
// echo 'Endval ';
// pr($end);
// echo 'Maxval ';
// pr($maxval);
// echo 'Nextval ';
// pr($nextVal);

      // checking if within range
      if( ($mf['ft_type'] == 'Range' || $mf['ft_type'] == 'IP Range') ) {
        if( $start <= $nextVal && $nextVal <= $end ) {}
        else {

// echo 'Range excep ';
// pr($nextVal);

          $error = $mf['ft_label'] . ' value of ' . ( $mf['ft_type'] == 'IP Range' ? long2ip($nextVal) : $nextVal ) . ' is out of range.';
          throw new RangeException($error);
        }
      }
// pr('line 566...');
// pr($mf);
      // returning next value
      if($mf['ft_type'] == 'IP' || $mf['ft_type'] == 'IP Range') $nextVal = long2ip($nextVal);
      else if($mf['ft_data_type'] == 'Text') $nextVal = chr($nextVal);

// echo 'Returnval ';
// pr($nextVal);
// pr('----------------');

      return $nextVal;
    }


    public function releaseprovision() {

      try {

        DB::beginTransaction();

        $radioInv = $carrierInv = [];

        // get staged radio inventory
        $radioInv = ProvisionRadioItem::where('provision_id', $this->_id)
                                        ->where('status', 'Staged')
                                        ->lists('sku');

        // get staged carrier inventory
        $carrierInv = ProvisionRadioItemCarrierItem::where('provision_id', $this->_id)
                                        ->where('status', 'Staged')
                                        ->lists('sku');

        // it makes sense to get rid of nonsense
        $radioInv = array_filter($radioInv);
        $carrierInv = array_filter($carrierInv);

        // release radio item
        ProvisionRadioItem::where('provision_id', $this->_id)
                            ->where('status', 'Staged')
                            ->update( ['status' => 'Released'] );


        // release radio item feature
        ProvisionRadioItemFeature::where('provision_id', $this->_id)
                                  ->where('status', 'Staged')
                                  ->update( ['status' => 'Released'] );

        // release radio inventory
        RadioInventory::whereIn('sku', $radioInv)
                        ->update( ['status' => 'Available'] );

        // check if carrier is present
        if($this->carrier_id) {

          // if carrier then release carrier item
          ProvisionRadioItemCarrierItem::where('provision_id', $this->_id)
                                        ->where('status', 'Staged')
                                        ->update( ['status' => 'Released'] );

          // if carrier then release carrier item feature
          ProvisionRadioItemCarrierItemFeature::where('provision_id', $this->_id)
                                                ->where('status', 'Staged')
                                                ->update( ['status' => 'Released'] );

          // release carrier inventory
          CarrierInventory::whereIn('sku', $carrierInv)
                            ->update( ['status' => 'Available'] );
        }

        // mark provision as released
        $this->status = 'Released';
        $this->save();

      }
      // catch(RangeException $e) {
      //   DB::rollback();
      //   pr($e->getMessage(), 1);
      //   return $e->getMessage();
      // }
      catch(Exception $e) {
        DB::rollback();
        //pr($e->getMessage(), 1);
        return false;
      }
      DB::commit();
      return true;
    }

    public function updatedeployment($input, $uid=0) {

      try {

        DB::beginTransaction();

        $status = $input['status'];

        $data = $input['payload'];

//pr($input);

        // fetching the radio item
        $pri = ProvisionRadioItem::find($data['rpid']);

        // if($pri->status != 'Staged') {
        //   $error = 'Item is not Staged or already Deployed.';
        //   throw new Exception($error);
        // }

//pr($pri);

        $template = $pri->template;

        // update provision radio item
        $pri->user_id = $uid;
        $pri->deployed_at = Carbon::now()->format('Y-m-d H:i:s');
        $pri->sku = $data['serial'];
        $pri->status = $status;
        $pri->save();

        // update status of all radio item features where value assigned by is m2m
        ProvisionRadioItemFeature::where('radio_item_id', $pri->_id)
                                    ->where('ft_value_assigned_by', 'Provisioner')
                                    ->update( [ 'status' => $status ] );

        // update radio inventory
        if($template->needvendorsno()) {
          $pri->inventory->status = $status;
          $pri->inventory->save();
        }

        // updating radio item features returned by Radio Admin
        $ftrs = array_except($data, ['rpid', 'username', 'password', 'ruk', 'serial', 'carriers']);

//pr($ftrs);

        $upftrs = [];
        if(count($ftrs) > 0) {
          foreach($ftrs as $ft => $ftv) {
            $ft_label = $this->getFeatureNameFromSendable($ft);

            // getting teh value fiedl name in the database
            $ft_fld   = $this->getFeatureFieldName($ft_label, 'vmf_');

            // fetching the radio item feature matching to the current feature
            $pri_ftr = $pri->features()
                            ->where('ft_fld_name', $ft_fld)
                            ->where('ft_value_assigned_by', 'Radio Admin')
                            ->first();

            if($pri_ftr) {
              $pri_ftr->ft_fld_value = $ftv;//assigning values
              $pri_ftr->status = $status;
              $pri_ftr->save();// saving values
            }
          }
        }

        // update carrier items if present
        if(isset($data['carriers']) && count($data['carriers'])>0) {
          $cids = $cskus = [];
          foreach($data['carriers'] as $ci) {
            $cids[]  = $ci['cpid'];
            $cskus[] = $ci['serial'];

            // update carrier item of provision radio item
            ProvisionRadioItemCarrierItem::find($ci['cpid'])->update( [ 'status' => $status, 'sku' => $ci['serial'] ] );
          } 

          // $cids = ProvisionRadioItemCarrierItem::whereIn('sku', $cskus)->get()->lists('_id');

          // update status of all radio item features where value assigned by is m2m
          ProvisionRadioItemCarrierItemFeature::whereIn('carrier_item_id', $cids)
                                                ->where('ft_value_assigned_by', 'Provisioner')
                                                ->update( [ 'status' => $status ] );

          // update radio inventory
          if($template->needcarriersno())
            CarrierInventory::whereIn('sku', $cskus)
                          ->update( [ 'status' => $status ] );
        }

      }
      // catch(RangeException $e) {
      //   DB::rollback();
      //   pr($e->getMessage(), 1);
      //   return $e->getMessage();
      // }
      catch(Exception $e) {
        DB::rollback();
        //pr($e->getMessage(), 1);
        //return false;
        return $e->getMessage();
      }
      DB::commit();
      return true;
    }


    protected function getFeatureNameFromSendable($txt='') {

      $txt = str_replace("_", " ", $txt);
      return $txt;
    }


}