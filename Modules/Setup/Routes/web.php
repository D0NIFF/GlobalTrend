<?php

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

use Illuminate\Support\Facades\Route;

Route::middleware(['auth','admin'])->prefix('setup')->group(function() {

    Route::get('/introPrefix', 'IntroPrefixController@index')->name('introPrefix.index');
    Route::post('/introPrefix/store', 'IntroPrefixController@store')->name('introPrefix.store')->middleware('prohibited_demo_mode');
    Route::post('/introPrefix/edit', 'IntroPrefixController@edit')->name('introPrefix.edit')->middleware('prohibited_demo_mode');
    Route::put('/introPrefix/update/{id}', 'IntroPrefixController@update')->name('introPrefix.update')->middleware('prohibited_demo_mode');
    Route::get('/introPrefix/destroy/{id}', 'IntroPrefixController@destroy')->name('introPrefix.destroy');
    Route::get('/introPrefix/search', 'IntroPrefixController@index')->name('introPrefix.search_index');


    Route::get('/tags', 'TagController@index')->name('tags.index');
    Route::get('/get-tag-list', 'TagController@get_list')->name('tags.get_list');
    Route::get('/get_data', 'TagController@get_data')->name('tags.get_data');
    Route::post('/tag-store', 'TagController@store')->name('tags.store')->middleware('prohibited_demo_mode');
    Route::post('/tag-update/{id}', 'TagController@update')->name('tags.update')->middleware('prohibited_demo_mode');
    Route::get('/tag/destroy/{id}', 'TagController@destroy')->name('tags.destroy')->middleware('prohibited_demo_mode');
    Route::get('/getTagBySentence', 'TagController@getTagBySentence')->name('tags.getTagBySentence');

    // location
    Route::get('/location/country', 'CountryController@index')->name('setup.country.index')->middleware(['permission', 'auth']);
    Route::post('/location/country/store', 'CountryController@store')->name('setup.country.store')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::get('/location/country/edit/{id}', 'CountryController@edit')->name('setup.country.edit');
    Route::post('/location/country/update', 'CountryController@update')->name('setup.country.update')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::post('/location/country/status', 'CountryController@status')->name('setup.country.status')->middleware(['permission', 'auth','prohibited_demo_mode']);

    Route::get('/location/state', 'StateController@index')->name('setup.state.index')->middleware(['permission', 'auth']);
    Route::get('/location/state/get-data', 'StateController@getData')->name('setup.state.getData');
    Route::post('/location/state/store', 'StateController@store')->name('setup.state.store')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::get('/location/state/edit/{id}', 'StateController@edit')->name('setup.state.edit');
    Route::post('/location/state/update', 'StateController@update')->name('setup.state.update')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::post('/location/state/status', 'StateController@status')->name('setup.state.status')->middleware(['permission', 'auth','prohibited_demo_mode']);

    Route::get('/location/city', 'CityController@index')->name('setup.city.index')->middleware(['permission', 'auth']);
    Route::get('/location/city/get-data', 'CityController@getData')->name('setup.city.getData');
    Route::post('/location/city/store', 'CityController@store')->name('setup.city.store')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::get('/location/city/edit/{id}', 'CityController@edit')->name('setup.city.edit');
    Route::post('/location/city/update', 'CityController@update')->name('setup.city.update')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::post('/location/city/status', 'CityController@status')->name('setup.city.status')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::post('/location/city/get-state', 'CityController@getState')->name('setup.city.get-state');


});

Route::middleware(['auth'])->prefix('setup')->group(function() {
    Route::get('/checkout-page-setup', 'SetupController@checkoutPageSetup')->name('setup.checkout.page.setup');
    Route::post('/update-checkout-page-setup', 'SetupController@updateCheckoutPageSetupData')->name('setup.update.checkout.field.settings');
    //one click order receive
    Route::get('/one-click-order-complete','SetupController@oneClickOrderReceive')->name('setup.one.click.order.receive');
    Route::post('/update-oneclickorder-status', 'SetupController@updateOneClickOrderStatus')->name('setup.update.oneclickorder.status');
    //Algolia search configuration
    Route::get('/algolia-search-config','SetupController@algoliaSearchConfig')->name('setup.algolia.search.config');
    Route::post('/update-algolia-search-config', 'SetupController@updateAlgoliaSearchConfig')->name('setup.update.algolia.search.config');
    Route::get('/import-data-to-algolia','SetupController@importDataToAlgolia')->name('setup.import.data.to.algolia');
    //Partial payment configuration
    Route::get('/partial-payment-config','SetupController@partialPaymentConfig')->name('setup.partial.payment.config');
    Route::post('/update-partial-payment-config', 'SetupController@updatePartialPaymentConfig')->name('setup.update.partial.payment.config');

});

Route::get('/setup/getTagBySentence', 'TagController@getTagBySentence')->name('tags.getTagBySentence');
Route::middleware(['auth','admin'])->prefix('generalsetting')->group(function() {
    //analytics tool
    Route::get('/analytics', 'AnalyticsToolController@index')->name('setup.analytics.index')->middleware(['permission']);
    Route::get('/google-maps-api', 'GoogleMapsApiController@index')->name('setup.maps.index')->middleware(['permission']);
    Route::post('/google-maps-api-update', 'GoogleMapsApiController@update')->name('setup.google-maps-api-update')->middleware(['permission','prohibited_demo_mode']);;
    Route::post('/analytics/google-analytics-update', 'AnalyticsToolController@googleAnalyticsUpdate')->name('setup.google-analytics-update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/analytics/facebook-pixel-update', 'AnalyticsToolController@facebookPixelUpdate')->name('setup.facebook-pixel-update')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/google-recaptcha', 'GoogleRecaptchaController@index')->name('setup.recaptcha.index')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/google-recaptcha-update', 'GoogleRecaptchaController@update')->name('setup.recaptcha.update')->middleware(['permission','prohibited_demo_mode']);
});


Route::prefix('hr')->middleware(['auth','admin'])->group(function(){
    Route::get('/departments', 'DepartmenController@index')->name('departments.index');
    Route::post('/departments-store', 'DepartmenController@store')->name('departments.store')->middleware('prohibited_demo_mode');
    Route::post('/departments-update', 'DepartmenController@update')->name('departments.update')->middleware('prohibited_demo_mode');
    Route::post('/departments-delete', 'DepartmenController@delete')->name('departments.delete')->middleware('prohibited_demo_mode');
});

Route::get('/setup/tags/get-by-ajax', 'TagController@getByAjax')->name('setup.tag.get-by-ajax')->middleware(['auth']);
