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

Auth::routes(['register' => false]);
Route::group(['prefix' => 'backend', 'namespace' => 'Backend', 'middleware' => 'auth'], function () {

    Route::post('/car/change-status', 'ChangeCarController@changeStatus')->name('car.change-status');
    Route::post('/car/change-public', 'ChangeCarController@changePublic')->name('car.change-public');
    Route::post('/car/change-private', 'ChangeCarController@changePrivate')->name('car.change-private');
    Route::post('/car/{car}', 'CarController@update'); // because  new FormData(this)  not working with put method
    Route::resource('car', 'CarController')->except(['edit', 'create']);

    Route::post('/trip/change-status', 'TripController@changeStatus')->name('trip.change-status');
    Route::get('/trip/{trip}/seats', 'TripController@seats')->name('trip.seats');
    Route::resource('trip', 'TripController')->except(['edit', 'create']);

    Route::post('/type-car/change-status', 'TypeCarController@changeStatus')->name('type-car.change-status');
    Route::resource('type-car', 'TypeCarController')->except(['edit', 'create']);

    Route::resource('governorate', 'GovernorateController')->except(['edit', 'create']);

    Route::resource('city', 'CityController')->except(['edit', 'create']);

    Route::resource('passenger', 'PassengerController')->only(['index']);

    Route::resource('owner', 'OwnerController')->only(['index', 'store', 'destroy']);

    Route::resource('driver', 'DriverController')->only(['index', 'store', 'destroy']);

    Route::resource('citiescar', 'CitiesCarController')->only(['index', 'store', 'destroy']);

    Route::resource('setting', 'SettingController')->only(['index', 'store']);

    Route::resource('profile-setting', 'ProfileSettingController')->only(['index', 'store']);

    Route::resource('change-password', 'ChangePasswordController')->only(['index', 'store']);

    Route::resource('dashboard', 'DashboardController')->only(['index', 'store']);

    Route::resource('permissions', 'PermissionsController')->except(['edit', 'create']);

    Route::post('/roles/role-permissions', 'RolesController@rolePermissions')->name('role-permissions');
    Route::get('/roles/role-permissions/{id}', 'RolesController@getRolePermissions')->name('get-role-permissions');

    Route::resource('roles', 'RolesController')->except(['edit', 'create']);

    Route::resource('notifications', 'NotificationController')->only(['index', 'store', 'destroy']);
});

Route::namespace ('Frontend')->group(function () {
    Route::get('/', 'HomeController');
    Route::get('private', 'PrivateController');
    Route::get('search', 'SearchController');
    Route::post('seats', 'SeatController')->name('seats');
    Route::post('booking', 'bookingController');
});
