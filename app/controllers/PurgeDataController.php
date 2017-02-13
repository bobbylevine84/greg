<?php

class PurgeDataController extends BaseController {

    //private $ppg;// items shown per page when paginated
    protected $customer;

    public function __construct(CUSTOMER $customer) {

        parent::__construct();

        // Superadmin Access
        $this->beforeFilter(function() {
            $app = App::make('myApp');
            if($app->isSU)
                return Redirect::to('error')
                        ->withErrors([
                                        'errorcode'  => '500',
                                        'errormsg'   => 'Oops! You have do not have access to the resource.',
                                        'suggestion' => 'Please try a different page.'
                                    ]);
        }, array('only' => ['getMyaccount', 'postUpdatemyaccount', 'getChangepassword', 'postUpdatepassword', 'getShowaccount', 'getCompany', 'postUpdatecompany']));

        // Customer Access
        $this->beforeFilter(function() {
            $app = App::make('myApp');
            if($app->utype == 'CUSTOMER')
                return Redirect::to('error')
                        ->withErrors([
                                        'errorcode'  => '500',
                                        'errormsg'   => 'Oops! You have do not have access to the resource.',
                                        'suggestion' => 'Please try a different page.'
                                    ]);
        }, array('except' => ['getMyaccount', 'postUpdatemyaccount', 'getChangepassword', 'postUpdatepassword', 'getShowaccount', 'getCompany', 'postUpdatecompany']));

        // Customer Access
        $this->beforeFilter(function() {
            $app = App::make('myApp');
            if($app->utype == 'USER')
                return Redirect::to('error')
                        ->withErrors([
                                        'errorcode'  => '500',
                                        'errormsg'   => 'Oops! You have do not have access to the resource.',
                                        'suggestion' => 'Please try a different page.'
                                    ]);
        }, array('except' => ['getCompany', 'postUpdatecompany']));

        $this->customer = $customer;
        //$this->ppg        = 20;
        $this->menu = 'purgedata';// for selecting sidemenu
    }

    public function anyIndex() {
        $params = array();
        $pgn = Input::get('page', 1);
        $clr = Input::get('btnClear', false);
        $srh = Input::get('btnSearch', false);
        $srt = [ 'srchOBy' => 'comp_name', 'srchOTp' => 'asc' ];

        if($srh) $params = Input::all();
        else if($clr) {
            Session::forget('PARAMS_PURGECUSTOMERSEARCH');
            $params = array();
        }
        else $params = Session::get('PARAMS_PURGECUSTOMERSEARCH', array());

        // merging defaut sorting values
        $params = array_merge($srt, $params);

        Session::put('PARAMS_PURGECUSTOMERSEARCH', $params);
                                                       
        $customers = $this->customer->search($pgn, $this->ppg, $params);

        return $this->setView('purgedata.index', [ 'params' => $params, 'records' => $customers ]);
    }

    public function getPurge($custID) {
        // fetch and delete the record
        CUSTOMER::purge($custID);        
        Session::flash('flash-done', 'Customer purged successfully.');
        return Redirect::to('purgedata/index');
    }


    public function missingMethod($parameters = array()) {
        //pr($parameters);
        return 'Sorry! but "' . array_shift($parameters).'" does not exist...';
    }

    public function getFlushparams() {
        Session::forget('PARAMS_PURGECUSTOMERSEARCH');
        echo 'all params flushed...';
    }

}