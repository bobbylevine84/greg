<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
Route::get('/', function()
{
    return View::make('hello');
});
*/

Route::group(array('before' => 'auth'), function() {

    Route::get('logout', function() {
        //Auth::logout();
        Auth::admin()->logout();
        Auth::customer()->logout();
        Auth::user()->logout();
        Session::flush();
        return Redirect::to('login');
    });

    // Root
    // Route::get('/', function() {
    //     return View::make('dashboard');
    // });

    //Route::get('/', 'BaseController@dashboard');
    Route::get('/', [ 'as' => 'root', function() {
        $app = App::make('myApp');
        if($app->isSU) return Redirect::route('customer.index');
        elseif($app->isCustAdmin) return Redirect::route('groups.index');
        else return Redirect::route('user.useraccount');
    }]);

    // Superadmin Account
    Route::controller(
                        'saaccount', 
                        'SAAccountController', 
                        [
                            'getChangepassword' => 'saaccount.changepassword',
                            'postUpdatepassword' => 'saaccount.updatepassword',
                        ]
                    );


    // Master Data
    Route::controller(
                        'masterdata', 
                        'MasterDataController', 
                        [
                            'anyIndex'                           => 'masterdata.index', 
                            'anyVendormodelfeature'              => 'masterdata.vendormodelfeature',
                            'getCreatevendormodelfeature'        => 'masterdata.createvendormodelfeature',
                            'postStorevendormodelfeature'        => 'masterdata.storevendormodelfeature',
                            'getEditvendormodelfeature'          => 'masterdata.editvendormodelfeature',
                            'postUpdatevendormodelfeature'       => 'masterdata.updatevendormodelfeature',
                            'getDestroyvendormodelfeature'       => 'masterdata.destroyvendormodelfeature',
                            'getNewchildmouldvendormodelfeature' => 'masterdata.newchildmouldvendormodelfeature',

                            'anyCarriermodelfeature'              => 'masterdata.carriermodelfeature',
                            'getCreatecarriermodelfeature'        => 'masterdata.createcarriermodelfeature',
                            'postStorecarriermodelfeature'        => 'masterdata.storecarriermodelfeature',
                            'getEditcarriermodelfeature'          => 'masterdata.editcarriermodelfeature',
                            'postUpdatecarriermodelfeature'       => 'masterdata.updatecarriermodelfeature',
                            'getDestroycarriermodelfeature'       => 'masterdata.destroycarriermodelfeature',
                            'getNewchildmouldcarriermodelfeature' => 'masterdata.newchildmouldcarriermodelfeature',

                        ]
                    );

    // Vendor
    Route::controller(
                        'vendors', 
                        'VendorsController', 
                        [
                            'anyIndex' => 'vendors.index', 
                            'getCreate' => 'vendors.create',
                            'postStore' => 'vendors.store',
                            'getEdit' => 'vendors.edit',
                            'postUpdate' => 'vendors.update',
                            'getDestroy' => 'vendors.destroy',
                        ]
                    );

    // Vendor Model
    Route::controller(
                        'vendormodel', 
                        'VendorModelController', 
                        [
                            'anyIndex' => 'vendormodel.index', 
                            'getCreate' => 'vendormodel.create',
                            'postStore' => 'vendormodel.store',
                            'getEdit' => 'vendormodel.edit',
                            'postUpdate' => 'vendormodel.update',
                            'getDestroy' => 'vendormodel.destroy',
                            'getCustomers' => 'vendormodel.customers',
                        ]
                    );


    // Carrier
    Route::controller(
                        'carrier', 
                        'CarrierController', 
                        [
                            'anyIndex' => 'carrier.index', 
                            'getCreate' => 'carrier.create',
                            'postStore' => 'carrier.store',
                            'getEdit' => 'carrier.edit',
                            'postUpdate' => 'carrier.update',
                            'getDestroy' => 'carrier.destroy',
                        ]
                    );


    // Carrier Model
    Route::controller(
                        'carriermodel', 
                        'CarrierModelController', 
                        [
                            'anyIndex' => 'carriermodel.index', 
                            'getCreate' => 'carriermodel.create',
                            'postStore' => 'carriermodel.store',
                            'getEdit' => 'carriermodel.edit',
                            'postUpdate' => 'carriermodel.update',
                            'getDestroy' => 'carriermodel.destroy',
                            'getCustomers' => 'carriermodel.customers',
                        ]
                    );


    // Customer
    Route::controller(
                        'customer', 
                        'CustomerController', 
                        [
                            'anyIndex' => 'customer.index', 
                            'getCreate' => 'customer.create',
                            'postStore' => 'customer.store',
                            'getEdit' => 'customer.edit',
                            'postUpdate' => 'customer.update',
                            'postSetcurapp' => 'customer.setcurapp',

                            'getShowaccount' => 'customer.showaccount',
                            'getMyaccount' => 'customer.myaccount',
                            'postUpdatemyaccount' => 'customer.updatemyaccount',
                            'getChangepassword' => 'customer.changepassword',
                            'postUpdatepassword' => 'customer.updatepassword',

                            'getCompany' => 'customer.company',
                            'postUpdatecompany' => 'customer.updatecompany',
                        ]
                    );

    // Purge Data
    Route::controller(
                        'purgedata', 
                        'PurgeDataController', 
                        [
                            'anyIndex' => 'purgedata.index', 
                            'getPurge' => 'purgedata.purge',
                        ]
                    );

    // Group
    Route::controller(
                        'groups', 
                        'GroupsController', 
                        [
                            'anyIndex' => 'groups.index', 
                            'getCreate' => 'groups.create',
                            'postStore' => 'groups.store',
                            'getEdit' => 'groups.edit',
                            'postUpdate' => 'groups.update',
                            'getDestroy' => 'groups.destroy',
                        ]
                    );

    // User
    Route::controller(
                        'user', 
                        'UserController', 
                        [
                            'anyIndex' => 'user.index', 
                            'getCreate' => 'user.create',
                            'postStore' => 'user.store',
                            'getEdit' => 'user.edit',
                            'postUpdate' => 'user.update',
                            'getDestroy' => 'user.destroy',
                            'postSetcurapp' => 'user.setcurapp',
                            'getShowaccount' => 'user.showaccount',
                            'getMyaccount' => 'user.myaccount',
                            'postUpdatemyaccount' => 'user.updatemyaccount',
                            'getChangepassword' => 'user.changepassword',
                            'postUpdatepassword' => 'user.updatepassword',

                            'getUseraccount' => 'user.useraccount',

                            // 'getUserpassword' => 'user.userpassword',
                            // 'postUpdateuserpassword' => 'user.updateuserpassword',

                        ]
                    );


    // Import Radio Inventory
    Route::controller(
                        'radioinventory', 
                        'RadioInventoryController', 
                        [
                            'anyIndex' => 'radioinventory.index', 
                            'getCreate' => 'radioinventory.create',
                            'postStore' => 'radioinventory.store',
                            'getEdit' => 'radioinventory.edit',
                            'postUpdate' => 'radioinventory.update',
                            'getDestroy' => 'radioinventory.destroy',

                            'getVendormodels' => 'radioinventory.vendormodels',

                            'getImportfromfile' => 'radioinventory.importfromfile',
                            'postSaveimport' => 'radioinventory.saveimport',
                        ]
                    );

    // Import Carrier Inventory
    Route::controller(
                        'carrierinventory', 
                        'CarrierInventoryController', 
                        [
                            'anyIndex' => 'carrierinventory.index', 
                            'getCreate' => 'carrierinventory.create',
                            'postStore' => 'carrierinventory.store',
                            'getEdit' => 'carrierinventory.edit',
                            'postUpdate' => 'carrierinventory.update',
                            'getDestroy' => 'carrierinventory.destroy',

                            'getCarriermodels' => 'carrierinventory.carriermodels',

                            'getImportfromfile' => 'carrierinventory.importfromfile',
                            'postSaveimport' => 'carrierinventory.saveimport',
                        ]
                    );

    // Templates
    Route::controller(
                        'templates', 
                        'TemplatesController', 
                        [
                            'anyIndex' => 'templates.index', 
                            'getCreate' => 'templates.create',
                            'anyCopy' => 'templates.copy', 
                            'postStore' => 'templates.store',
                            'getEdit' => 'templates.edit',
                            'postUpdate' => 'templates.update',
                            'getDestroy' => 'templates.destroy',

                            'getVendormodels' => 'templates.vendormodels',
                            'getCarriermodels' => 'templates.carriermodels',

                            'getVendormodelfeaures' => 'templates.vendormodelfeaures',
                            'getCarriermodelfeaures' => 'templates.carriermodelfeaures',

                            'getVendormodelallfeatures' => 'templates.vendormodelallfeatures',
                            'getVendormodelfeature' => 'templates.vendormodelfeature',

                            'getCarriermodelallfeatures' => 'templates.carriermodelallfeatures',
                            'getCarriermodelfeature' => 'templates.carriermodelfeature',

                            'getView' => 'templates.view',
                        ]
                    );

    // Provision
    Route::controller(
                        'provision', 
                        'ProvisionController', 
                        [
                            'anyIndex' => 'provision.index', 
                            'getCreate' => 'provision.create',
                            'postStore' => 'provision.store',

                            'getTemplates' => 'provision.templates',
                            'getRelease' => 'provision.release',

                            // 'getEdit' => 'provision.edit',
                            // 'postUpdate' => 'provision.update',

                            // 'getDestroy' => 'provision.destroy',

                            // 'getCarriermodels' => 'provision.carriermodels',

                            // 'getVendormodelfeaures' => 'provision.vendormodelfeaures',
                            // 'getCarriermodelfeaures' => 'provision.carriermodelfeaures',

                            'getArchive' => 'provision.archive',
                        ]
                    );

    // Reports
    Route::controller(
                        'report', 
                        'ReportController', 
                        [
                            'anyIndex' => 'report.index', 

                            'anyRadioinventory' => 'report.radioinventory', 

                            'anyCarrierinventory' => 'report.carrierinventory', 

                            'anyGroups' => 'report.groups', 

                            'anyUser' => 'report.user', 

                            'anyDeploymentscomplated' => 'report.deploymentscompleted', 

                            'getDeploymentdetails' => 'report.deploymentdetails', 
                        ]
                    );

    // Settings
    Route::controller('appsetting', 'AppSettingController');

});

// login routes
Route::get('login', function() {
    if(Auth::admin()->check() || Auth::customer()->check() || Auth::user()->check()) return Redirect::to('/');

    //if(Auth::check()) return Redirect::to('/');

    return View::make('login');
});

Route::post('login', 'LoginController@login');
// end login routes

// Error page
Route::get('error', function() {

    $app = App::make('myApp');
    if(!$app->isLogedin) return Redirect::to('login');

    return View::make('errorpage', [ 'menu' => '' ]);
});

// API
Route::controller(
                    'userapi', 
                    'UserAPIController', 
                    [
                        'anyTestapi' => 'userapi.testapi', 

                        'anyGettest' => 'userapi.gettest', 

                        'anyTemplates' => 'userapi.templates', 

                        'anyProvisions' => 'userapi.provisions', 

                        'anyUpdate' => 'userapi.update', 

                        // 'anyCarrierinventory' => 'userapi.carrierinventory', 

                        // 'anyGroups' => 'userapi.groups', 

                        // 'anyUser' => 'userapi.user', 
                    ]
                );
