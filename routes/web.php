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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::prefix('backend')->middleware('auth')->group(function () {
    //Car
    Route::resource('car', 'Backend\CarController')->except(['edit','create']);
    Route::post('/car/changestatus', 'Backend\CarController@changestatus')->name('car.changestatus');
    Route::post('/car/changepublic', 'Backend\CarController@changepublic')->name('car.changepublic');
    Route::post('/car/changeprivate', 'Backend\CarController@changeprivate')->name('car.changeprivate');
    Route::post('/car/{car}', 'Backend\CarController@update'); // because  new FormData(this)  not working with put method

    //Trip
    Route::resource('trip', 'Backend\TripController')->except(['edit','create']);
    Route::post('/trip/changestatus', 'Backend\TripController@changestatus')->name('trip.changestatus');

    //TypeCar
    Route::resource('typecar', 'Backend\TypeCarController')->except(['edit','create']);
    Route::post('/typecar/changestatus', 'Backend\TypeCarController@changestatus')->name('typecar.changestatus');

    //Change Website Setting
    Route::resource('setting', 'Backend\SettingController')->only(['index','store']);

    //Change Profile Setting
    Route::resource('profile-setting', 'Backend\ProfileSettingController')->only(['index','store']);

    //Change Password
    Route::resource('change-password', 'Backend\ChangePasswordController')->only(['index','store']);

    //Dashboard
    Route::resource('dashboard', 'Backend\DashboardController')->only(['index','store']);

    //Permissions
    Route::resource('permissions', 'Backend\PermissionsController')->except(['edit','create']);

    //Roles
    Route::resource('roles', 'Backend\RolesController')->except(['edit','create']);
    Route::post('roles/role_permissions', 'Backend\RolesController@role_permissions')->name('role_permissions');
    Route::get('roles/role_permissions/{id}', 'Backend\RolesController@getrolepermissions')->name('getrolepermissions');

    //Notifications
    Route::resource('notifications', 'Backend\NotificationController')->only(['index','store','destory']);
});

Route::get('/home', 'HomeController@index')->name('home');
