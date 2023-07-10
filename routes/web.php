<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Auth::routes(['verify' => true, 'register' => false]);

Route::get('/', 'HomeController@welcome')->name('site.home')->middleware(['install', 'update']);

Route::middleware(['installed', 'auth', 'xss_clean', 'language'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home')->middleware("permission:dashboard.index");

    Route::get('profile', 'UserController@profile')->name('user.profile')->middleware("permission:profile.index");
    Route::put('profile/{user}', 'UserController@profileUpdate')->name('user.profile.update')->middleware("permission:profile.index");



    //activation
    Route::get('activation', 'ActivationController@activeLicense')->name('activation.active_form')->middleware("permission:activation.index");
    Route::post('activation', 'ActivationController@active')->name('activation.active')->middleware("permission:activation.index");
    
    Route::get('user-list', 'UserController@index')->name('user.list');
    Route::get('user-status/{user}', 'UserController@status')->name('user.status');

    Route::get('user/getListForDataTable', 'UserController@getListForDataTable')->name('userListJson');

    Route::get('user-create', 'UserController@create')->name('user.create');
    Route::post('user-create', 'UserController@store')->name('user.store');
    Route::delete('user/{user}', 'UserController@destroy')->name('user.destroy');

    Route::get('user-edit/{user}', 'UserController@edit')->name('user.edit');
    Route::put('user-edit/{user}', 'UserController@update')->name('user.update');

    Route::resource('category', 'CategoryController')->except(['show']);

    Route::resource('tariff', 'TariffController')->except(['show']);

    Route::get('reports/summary', 'ReportController@summary')->name('reports.summary')->middleware("permission:reports.summary");
    Route::get('reports/details-report', 'ReportController@detailsReport')->name('reports.details_report')->middleware("permission:reports.detail");
    Route::get('reports/slots-report', 'ReportController@slotsReport')->name('reports.slots_report')->middleware("permission:reports.slot");
    Route::get('reports/pdf', 'ReportController@pdf_report')->name('reports.pdf_report');
    Route::get('general-settings', 'SiteController@generalSettings')->name('settings.create')->middleware("permission:settings.index");
    Route::post('general-settings', 'SiteController@storeGeneralSettings')->name('settings.store')->middleware("permission:settings.index");
    Route::resource('roles', 'RoleController')->except(['show']);
    Route::resource('countries', 'CountryController')->except(['show']);
    Route::post('countries/default/{country}', 'CountryController@default')->name('user.default');

    Route::resource('states', 'StateController')->except(['show']);
    Route::post('states/default/{state}', 'StateController@default')->name('state.default');

    Route::resource('cities', 'CityController')->except(['show']);
    Route::post('cities/default/{city}', 'CityController@default')->name('city.default');

    Route::resource('floors', 'FloorController')->except(['show']);
    Route::get('floors/change-status/{floor}', 'FloorController@statusChange')->name('floors.status_changes');
    Route::resource('places', 'PlaceController')->except(['show']);
    Route::get('places/change-status/{place}', 'PlaceController@statusChange')->name('places.status_changes');
    Route::resource('parking-settings', 'CategoryWiseFloorSlotController', ['names' => 'parking_settings']);
    Route::get('parking-settings/change-status/{parking_setting}', 'CategoryWiseFloorSlotController@statusChange')->name('parking_settings.status_changes');
    Route::resource('languages', 'LanguageController');
    Route::get('language/change-language/{language}', 'LanguageController@language_change')->name('language.language_change');
    Route::post('language/update-language/{language}', 'LanguageController@language_update')->name('language.language_update');
    Route::get('languages/set-language/{language}', 'LanguageController@set_languages')->name('languages.set_languages');

    Route::get('parking/rfid-vehicles','RfidVehicleController@index')->name('parking_settings.rfid_vehicles.index');
    Route::get('parking/rfid-vehicles/create','RfidVehicleController@create')->name('parking_settings.rfid_vehicles.create');
    Route::post('parking/rfid-vehicles','RfidVehicleController@store')->name('parking_settings.rfid_vehicles.store');
    Route::get('parking/rfid-vehicles/{rfidVehicle}/edit','RfidVehicleController@edit')->name('parking_settings.rfid_vehicles.edit');
    Route::put('parking/rfid-vehicles/{rfidVehicle}/update','RfidVehicleController@update')->name('parking_settings.rfid_vehicles.update');
    Route::get('parking/rfid-vehicles/change-status/{rfidVehicle}', 'RfidVehicleController@statusChange')->name('parking_settings.rfid_vehicles.status_changes');
    Route::delete('parking/rfid-vehicles/{rfidVehicle}', 'RfidVehicleController@destroy')->name('parking_settings.rfid_vehicles.destroy');
    Route::get('parking/rfid-vehicles/endpoint','RfidVehicleController@endpoint')->name('parking_settings.rfid_vehicles.endpoint');

    Route::resource('parking-crud', 'ParkingController', ['names' => 'parking'])->except(['show']);
    Route::get('parking/get-current', 'ParkingController@currentList')->name('parking.current_list');
    Route::get('parking/get-ended', 'ParkingController@endedList')->name('parking.ended_list');
    Route::get('parking/{parking}/end', 'ParkingController@end')->name('parking.end');
    Route::get('parking/{parking}/barcode', 'ParkingController@barcode')->name('parking.barcode');
    Route::post('parking/{parking}/pay', 'ParkingController@pay')->name('parking.pay');
    Route::post('parking/quick-end', 'ParkingController@quick_end')->name('parking.quick_end');
    Route::get('parking/slot/{category_id}', 'ParkingController@parkingSlot')->name('parking.slot');
});

Route::fallback(function () {
    return response()->view('errors.404', ['error' => "Sorry! This page doesn't exist."], 404);
});
