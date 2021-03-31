<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register'=>false]);
Route::group(['prefix'=>'backend','namespace'=>'Backend','middleware'=>'auth'],function () {
    //Car
    Route::resource('car', 'CarController')->except(['edit','create']);
    Route::post('/car/changestatus', 'CarController@changestatus')->name('car.changestatus');
    Route::post('/car/changepublic', 'CarController@changepublic')->name('car.changepublic');
    Route::post('/car/changeprivate', 'CarController@changeprivate')->name('car.changeprivate');
    Route::post('/car/{car}', 'CarController@update'); // because  new FormData(this)  not working with put method
    //Trip
    Route::resource('trip', 'TripController')->except(['edit','create']);
    Route::post('/trip/changestatus', 'TripController@changestatus')->name('trip.changestatus');
    Route::get('/trip/{trip}/seats', 'TripController@seats')->name('trip.seats');
    //TypeCar
    Route::resource('typecar', 'TypeCarController')->except(['edit','create']);
    Route::post('/typecar/changestatus', 'TypeCarController@changestatus')->name('typecar.changestatus');
    //Governorate
    Route::resource('governorate', 'GovernorateController')->except(['edit','create']);
    //City
    Route::resource('city', 'CityController')->except(['edit','create']);
    //Passenger
    Route::resource('passenger', 'PassengerController')->only(['index']);
    //Owner
    Route::resource('owner', 'OwnerController')->only(['index','store','destroy']);
    //Driver
    Route::resource('driver', 'DriverController')->only(['index','store','destroy']);
    //Driver
    Route::resource('citiescar', 'CitiesCarController')->only(['index','store','destroy']);
    //Change Website Setting
    Route::resource('setting', 'SettingController')->only(['index','store']);
    //Change Profile Setting
    Route::resource('profile-setting', 'ProfileSettingController')->only(['index','store']);
    //Change Password
    Route::resource('change-password', 'ChangePasswordController')->only(['index','store']);
    //Dashboard
    Route::resource('dashboard', 'DashboardController')->only(['index','store']);
    //Permissions
    Route::resource('permissions', 'PermissionsController')->except(['edit','create']);
    //Roles
    Route::resource('roles', 'RolesController')->except(['edit','create']);
    //Role Permissions
    Route::post('/roles/role_permissions', 'RolesController@role_permissions')->name('role_permissions');
    Route::get('/roles/role_permissions/{id}', 'RolesController@getrolepermissions')->name('getrolepermissions');
    //Notifications
    Route::resource('notifications', 'NotificationController')->only(['index','store','destroy']);
});

Route::prefix('')->group(function () {
    //main page
    Route::get('/','Frontend\HomeController@index');
    //get only available private car
    Route::get('/private','Frontend\HomeController@private');
    Route::resource('/search','Frontend\SearchController')->only(['index']);
    Route::post('/seats','Frontend\SearchController@seats')->name('seats');
    Route::resource('/booking','Frontend\bookingController')->only(['store']);

});
Route::get('/home','HomeController@index');
