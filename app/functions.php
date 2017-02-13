<?php

	//$IPTypes = [ 'IP', 'IP Range' ];

	function pr($arr, $e=0) {
		if(is_array($arr)) {
			echo "<pre>";
			print_r($arr);
			echo "</pre>";		
		}
		else {
			echo "<br>Not an array...<br>";
			echo "<pre>";
			var_dump($arr);
			echo "</pre>";
		}

		if($e) exit();
		else echo "<br>";
	}

	function show($v, $itm='', $d='') {
		if(!isset($v)) return $d;
		if($itm!='') $ret = array_get($v, $itm);
		else $ret = $v;

		return $ret == '' ? $d : $ret;
	}

	function getVErrorMessages($vErrors) {
		$ret = [];
		$messages = $vErrors->getMessages();
		if(is_array($messages) && count($messages)>0) {
			foreach($messages as $k => $v) {
				if(is_array($v) && array_key_exists(0, $v)) $ret[$k] = $v[0];
			}
		}
		return $ret;
	}

	function getNiceNames($s1=[], $s2=[], $s3=[], $s4=[]) {
		$ret = [];
		if(is_array($s1) && count($s1)>0) {
			foreach($s1 as $f) $ret[$f] = ucwords(str_replace('_', ' ', $f));
		}
		if(is_array($s2) && count($s2)>0) {
			foreach($s2 as $f) $ret[$f] = ucwords(str_replace('_', ' ', $f));
		}
		if(is_array($s3) && count($s3)>0) {
			foreach($s3 as $f) $ret[$f] = ucwords(str_replace('_', ' ', $f));
		}
		if(is_array($s4) && count($s4)>0) {
			foreach($s4 as $f) $ret[$f] = ucwords(str_replace('_', ' ', $f));
		}
		return $ret;
	}

	function getCustomerforAdmin() {
		$app = App::make('myApp');

		// if logged user is customer himself
		if($app->utype == 'CUSTOMER') return CUSTOMER::find($app->uid);
		// if logged user is an user with administrator privilege
		else if($app->utype == 'USER' && $app->isCustAdmin) return CUSTOMER::find($app->custAdminID);

		return (new CUSTOMER());
	}

    function getTheBoss() {
      $app = App::make('myApp');

      // if logged user is customer himself
      if($app->utype == 'CUSTOMER') return CUSTOMER::find($app->uid);
      // if logged user is an user with administrator privilege
      else if($app->utype == 'USER') return CUSTOMER::find($app->pid);

      return (new CUSTOMER());
      //return null;
    }

    function trimToInteger($n) {
    	if(is_numeric($n)) {
			$rn = round($n);
			$n = $n == $rn ? $rn : $n;
    	}
    	return $n;
    }

    function iptono(&$v, $k) {
    	$v = $v && filter_var($v, FILTER_VALIDATE_IP) !== false ? sprintf("%u", ip2long($v)) : $v;
    }

    function getFeatureFieldName($txt='', $pre='') {
        $fld = preg_replace("/[^a-zA-Z0-9\s_]+/", "", $txt );
        $fld = str_replace(" ", "_", $fld);
        $fld = strtolower($fld);

        return $pre . $fld;
    }

?>