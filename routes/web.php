<?php

// namespace LucaDegasperi\OAuth2Server\Facades;

 Route::get('testing', 'TestController@testing');
 //Route::get('/testing', function(){
 //	return view('testing');
// });
Route::get('/', function () {
    return view('welcome');
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [ 'middleware' => 'web'], function($api){
	$api->post('search','App\Http\Controllers\SearchController@search');
});

$api->version('v1', function($api){
	$api->post('private','App\Http\Controllers\SearchController@private');
});

$api->version('v1', function($api){
	$api->post('bulk','App\Http\Controllers\SearchController@bulk');
});

$api->version('v1', function($api){
	$api->post('register','App\Http\Controllers\RegisterController@register');
});

$api->version('v1', function($api){
	$api->post('activate','App\Http\Controllers\RegisterController@activate');
});

$api->version('v1', function($api){
	$api->post('verify','App\Http\Controllers\RegisterController@verify');
});

$api->version('v1', function($api){
	$api->post('valid','App\Http\Controllers\RegisterController@valid');
});

$api->version('v1', ['middleware' => 'web'], function($api){
	$api->post('login','App\Http\Controllers\RegisterController@login');
});

$api->version('v1', function($api){
	$api->post('company','App\Http\Controllers\RegisterController@company');
});

$api->version('v1', function($api){
	$api->post('validCompany','App\Http\Controllers\RegisterController@validCompany');
});

$api->version('v1', function($api){
	$api->post('forgot','App\Http\Controllers\RegisterController@forgot');
});

$api->version('v1', function($api){
	$api->post('resetPassword','App\Http\Controllers\RegisterController@resetPassword');
});


//Api Token Authentication
$api->version('v1', function($api){
	$api->post('apiRegister','App\Http\Controllers\AuthController@apiRegister');
});

$api->version('v1', function($api){
	$api->post('authenticate','App\Http\Controllers\AuthController@authenticate');
});


//Filling admin dashboard
$api->version('v1', function($api){
	$api->get('registeredUsers','App\Http\Controllers\DashboardController@registeredUsers');
});
$api->version('v1', function($api){
	$api->get('subscribedUsers','App\Http\Controllers\DashboardController@subscribedUsers');
});
$api->version('v1', function($api){
	$api->get('transactions','App\Http\Controllers\DashboardController@transactions');
});
$api->version('v1', function($api){
	$api->get('searches','App\Http\Controllers\DashboardController@searches');
});




//Routes to import and export excel sheets for bulk verification
$api->version('v1', function($api){
	$api->get('downloadExcel','App\Http\Controllers\ExcelController@downloadExcel');
});

$api->version('v1', function($api){
	$api->get('importExport','App\Http\Controllers\ExcelController@importExport');
});
$api->version('v1', function($api){
	$api->post('importExcel','App\Http\Controllers\ExcelController@importExcel');
});


$api->version('v1', function($api){
	$api->get('deleteExcel','App\Http\Controllers\ExcelController@deleteExcel');
});
//credits check
$api->version('v1', function($api){
	$api->post('creditsBal','App\Http\Controllers\RegisterController@creditsBal');
});


$api->version('v1', function($api){
	$api->post('credits','App\Http\Controllers\RegisterController@credits');
});


$api->version('v1', function($api){
	$api->post('creditsCheck','App\Http\Controllers\RegisterController@creditsCheck');
});

$api->version('v1', function($api){
	$api->post('creditsBulk','App\Http\Controllers\RegisterController@creditsBulk');
});


$api->version('v1', function($api){
	$api->post('getId','App\Http\Controllers\RegisterController@getId');
});


//setting sessions
$api->version('v1', ['middleware' => 'web'], function($api){
	$api->get('session/get','App\Http\Controllers\UserController@accessSessionData');
});

$api->version('v1', ['middleware' => 'web'], function($api){
	$api->get('session/set','App\Http\Controllers\UserController@storeSessionData');
});

$api->version('v1', ['middleware' => 'web'], function($api){
	$api->get('session/remove','App\Http\Controllers\UserController@deleteSessionData');
});


//homepage sessions
$api->version('v1', ['middleware' => 'web'], function($api){
	$api->get('sessions','App\Http\Controllers\RegisterController@sessions');
});

$api->version('v1', ['middleware' => 'web'], function($api){
	$api->get('logout','App\Http\Controllers\RegisterController@logout');
});



//lock screen
$api->version('v1', ['middleware' => 'web'], function($api){
	$api->post('lockScreen','App\Http\Controllers\RegisterController@lockScreen');
});

//Short code routes
$api->version('v1', function($api){
	$api->post('join','App\Http\Controllers\PhoneController@join');
});

$api->version('v1', function($api){
	$api->post('phoneRegister','App\Http\Controllers\PhoneController@phoneRegister');
});


$api->version('v1', function($api){
	$api->post('codeCheck','App\Http\Controllers\PhoneController@codeCheck');
});

// 'before' => 'oauth', 

//knec api
$api->version('v1', function($api){
	$api->post('knecCert','App\Http\Controllers\PhoneController@knecCert');
});


//history search
$api->version('v1', function($api){
	$api->post('history','App\Http\Controllers\SearchController@history');
});

$api->version('v1',['middleware' => 'web'], function($api){
	$api->post('historyData','App\Http\Controllers\SearchController@historyData');
});

$api->version('v1', function($api){
	$api->post('usedCredits','App\Http\Controllers\PostaRegistrationController@usedCredits');
});

$api->version('v1', function($api){
	$api->post('updateCredits','App\Http\Controllers\PostaRegistrationController@updateCredits');
});
$api->version('v1', function($api){
	$api->post('updateTrackingId','App\Http\Controllers\PostaRegistrationController@updateTrackingId');
});

//Pesapal
$api->version('v1', function($api){
	$api->post('pesapalIframe','App\Http\Controllers\PesapalController@pesapalIframe');
});

$api->version('v1', function($api){
	$api->get('paymentconfirmation','App\Http\Controllers\PaymentController@paymentconfirmation');
});

$api->version('v1', function($api){
	$api->get('handleIPN','App\Http\Controllers\PesapalController@handleIPN');
});

Route::get('handleCallback', ['as' => 'handleCallback', 'uses'=>'PesapalController@handleCallback']);

// Route::get('handleCallback','App\Http\Controllers\PesapalController@handleCallback');
// Route::get('handleIPN','App\Http\Controllers\PesapalController@handleIPN');


// Route::group(['prefix' => '/webhooks'], function () {
//     //PESAPAL
    Route::get('donepayment', ['as' => 'paymentsuccess', 'uses'=>'PaymentController@paymentsuccess']);
    Route::get('paymentconfirmation', 'PaymentController@paymentconfirmation');
// });

$api->version('v1',function($api){
	$api->post('fetchProfile','App\Http\Controllers\RegisterController@fetchProfile');
});
$api->version('v1', function($api){
	$api->post('getUserData','App\Http\Controllers\PostaRegistrationController@getUserData');
});
$api->version('v1', function($api){
	$api->post('transactionData','App\Http\Controllers\PostaRegistrationController@transactionData');
});
$api->version('v1', function($api){
	$api->post('getTransactionData','App\Http\Controllers\PostaRegistrationController@getTransactionData');
});



//Posta Admins Endpoints
$api->version('v1', function($api){
	$api->post('verifyPhone','App\Http\Controllers\PostaRegistrationController@verifyPhone');
});
$api->version('v1', function($api){
	$api->post('registerAdmin','App\Http\Controllers\PostaRegistrationController@registerAdmin');
});
$api->version('v1', function($api){
	$api->post('loginAdmin','App\Http\Controllers\PostaRegistrationController@loginAdmin');
});
$api->version('v1', function($api){
	$api->post('alerts','App\Http\Controllers\PostaRegistrationController@alerts');
});
$api->version('v1', function($api){
	$api->get('getAlerts','App\Http\Controllers\PostaRegistrationController@getAlerts');
});
$api->version('v1', function($api){
	$api->post('addAlert','App\Http\Controllers\PostaRegistrationController@addAlert');
});
$api->version('v1', function($api){
	$api->post('editAlert','App\Http\Controllers\PostaRegistrationController@editAlert');
});
$api->version('v1', function($api){
	$api->post('deleteAlert','App\Http\Controllers\PostaRegistrationController@deleteAlert');
});
$api->version('v1', function($api){
	$api->post('addBox','App\Http\Controllers\PostaRegistrationController@addBox');
});
$api->version('v1', function($api){
	$api->post('subscribe','App\Http\Controllers\PostaRegistrationController@subscribe');
});
$api->version('v1', function($api){
	$api->post('notifications','App\Http\Controllers\PostaRegistrationController@notifications');
});
$api->version('v1', function($api){
	$api->post('getBox','App\Http\Controllers\PostaRegistrationController@getBox');
});
$api->version('v1', function($api){
	$api->post('getMessage','App\Http\Controllers\PostaRegistrationController@getMessage');
});

$api->version('v1', function($api){
	$api->post('getUsedCredits','App\Http\Controllers\PostaRegistrationController@getUsedCredits');
});

$api->version('v1', function($api){
	$api->post('getToken','App\Http\Controllers\RegisterController@getToken');
});






$api->version('v1', [ 'middleware' => 'web'], function($api){
	$api->post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});
});


Route::get('/register ',function(){$user = new App\User();
 $user->name="test user";
 $user->email="test@test.com";
 $user->password = \Illuminate\Support\Facades\Hash::make("password");
 $user->save();
 
});

Route::post('/register ',function(){$user = new App\User();
 
});