<?php

	//View::composer('layouts.default', function($view) {
	View::composer(['layouts.default', 'layouts.app'], function($view) {

		$display_name = 'Anonymous';
		if($view->myApp->isLogedin) {
			$display_name = $view->myApp->uname;//'Arindam';
    	}
		$view->with('display_name', $display_name);
	});

	// View::composer('layouts.app', function($view) {
	// 	$view->with('curuserapplist', $view->myApp->user->getapplist());
	// });

	// View::composer('layouts.app', function($view) {
	// 	$curselapp = '';
	// 	if(Session::has('CUR_APPID')) $curselapp = Session::get('CUR_APPID');
	// 	elseif($view->myApp->user->getdefaultapp()) $curselapp = $view->myApp->user->getdefaultapp();

	// 	if(!empty($curselapp)) Session::put('CUR_APPID', $curselapp);

	// 	$view->with('curselapp', $curselapp);
	// });
