<?php

class BaseController extends Controller {

	protected $ppg;// items shown per page when paginated
	protected $title;
	protected $bread;
	protected $menu;
	protected $administrator;

	public function __construct() {

		$this->title = $this->bread = '';// for page specific title and breadcrumb
		$this->menu = '';// for selecting sidemenu

		$this->ppg = Config::get('settings.items_per_page');

		$this->administrator = getCustomerforAdmin();
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	// protected function setupLayout() {
	// 	if ( ! is_null($this->layout)) {
	// 		$this->layout = View::make($this->layout);
	// 	}
	// }

	public function dashboard() {
		return View::make('dashboard');
	}

	protected function setView($v, $d=[]) {
		$d['menu']  = $this->menu;
		$d['title'] = $this->title;
		$d['bread'] = $this->bread;

		return View::make($v, $d);
	}

}
