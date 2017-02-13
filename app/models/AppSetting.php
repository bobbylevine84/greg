<?php

class AppSetting extends Eloquent {

/*
  `set_key` varchar(100) NOT NULL,
  `set_value` varchar(100) DEFAULT NULL,
  `set_name` varchar(1000) DEFAULT NULL
*/

  	protected $table = 'tbl_settings';
  	protected $primaryKey = 'set_key';
    protected $appends = [];

  	protected $guarded  = ['*'];
  	public $timestamps = false;

    function __construct() {
      parent::__construct();
    }

    public static function search($pgn=1, $ppg=20, $params=array()) {
    	$whr = " true ";
		if(isset($params['srchText']) && trim($params['srchText'])!='') {
			$whr .= " and ( ";
			$whr .= " set_key like '%".$params['srchText']."%' ";
	    	$whr .= " or set_value like '%".$params['srchText']."%' ";
			$whr .= " or set_name like '%".$params['srchText']."%' ";
			$whr .= " ) ";
		}

    	$sql = " select * from tbl_settings where " . $whr . " limit " . ($pgn - 1) * $ppg . ", " . $ppg;
    	$results = DB::select($sql);

		$ksql = " select count(*) as kount from tbl_settings where " . $whr;
		$kresult = DB::select($ksql);
		$kount = $kresult[0]->kount;

		// creating pagination
		$results = Paginator::make($results, $kount, $ppg);

		return $results;
    }

}