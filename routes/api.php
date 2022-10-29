<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'AuthController@register');

Route::get('/version', function (Request $request) {
    return response()->json("cultibot v1",200);
});

Route::group(['middleware' => ['auth:api']], function() {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('valida-rol', 'AuthController@testpermisos');
    });

    Route::group(['middleware' => ['permission:comercio.crear']], function () {
        Route::get('valida-permisos', 'AuthController@testpermisos');
    });


    Route::post('farm', 'FarmController@create');
    Route::get('farm', 'FarmController@index');
    Route::get('farm/{id}', 'FarmController@details');
    Route::post('farm/{id}', 'FarmController@update');

    Route::get('farm/{id_farm}/lots', 'FarmController@indexLots');
    Route::get('lot/{id_lot}', 'FarmController@detailsLot');
    Route::post('lot', 'FarmController@createLot');
    Route::post('lot/{id_lot}', 'FarmController@updateLot');
    Route::delete('farm/{id_farm}', 'FarmController@delete');

    Route::get('lot/{id_lot}/analysis', 'SoilAnalysisController@indexAnalysis');
    Route::delete('lot/{id_lot}', 'FarmController@deleteLot');
    Route::get('analysis/{id_analysis}', 'SoilAnalysisController@details');
    Route::post('analysis', 'SoilAnalysisController@create');
    Route::post('analysis/{id_analysis}', 'SoilAnalysisController@update');
    Route::delete('analysis/{id_analysis}', 'FarmController@deleteAnalysis');

    Route::get('product', 'InventoryAndProductController@listProducts');
    Route::post('product', 'InventoryAndProductController@createProduct');
    Route::post('product/{product_id}', 'InventoryAndProductController@updateProduct');
    Route::get('product/{product_id}', 'InventoryAndProductController@getDetailsProduct');
    Route::delete('product/{product_id}', 'InventoryAndProductController@deleteProduct');

    Route::get('product-type/{product_type_id}/product', 'InventoryAndProductController@getProductsByProductType');

    Route::post('inventory', 'InventoryAndProductController@createInventory');

    Route::get('inventory/product', 'InventoryAndProductController@inventoryProducts');
    Route::get('inventory/product/{product_id}', 'InventoryAndProductController@getInventaryProduct');
    Route::get('inventory/total/product-type', 'InventoryAndProductController@totalInventaryByTypeProduct');
    Route::get('inventory/total/product/{product_type_id}', 'InventoryAndProductController@totalInventoryByProduct');
    Route::delete('inventory/{inventory_id}', 'InventoryAndProductController@deleteInventory');

    Route::get('departments', 'UbicationController@department');
    Route::get('municipalities/{id_department}', 'UbicationController@municipalities');
    Route::get('villages/{id_munipality}', 'UbicationController@villages');

    Route::get('document-types', 'UtilitiesController@documentTypes');
    Route::get('holdings', 'UtilitiesController@holdings');
    Route::get('varieties-coffee', 'UtilitiesController@varietiesCoffee');
    Route::get('renewals', 'UtilitiesController@renewals');
    Route::get('type-renewals', 'UtilitiesController@typeRenewals');
    Route::get('brightnesses', 'UtilitiesController@brightnesses');
    Route::get('type-sombers', 'UtilitiesController@typeSombers');
    Route::get('strokes', 'UtilitiesController@strokes');
    Route::get('product-types', 'UtilitiesController@productTypes');
    Route::get('unit-measurements', 'UtilitiesController@unitMeasurements');

    Route::post('cost', 'CostController@create');
    Route::get('type-cost', 'CostController@getTypeCosts');
    Route::get('type-category', 'CostController@getTypeCategories');
    Route::get('type-activity', 'CostController@getTypeActivities');
    Route::get('stage', 'CostController@getStages');
    Route::get('type-work', 'CostController@getTypeWorks');
    Route::get('cost/administrative', 'CostController@getCostAdministrative');
    Route::get('cost/type-category/{type_category}/details', 'CostController@getCostAdministrativeDetails');
    Route::get('cost/activity', 'CostController@getCostActivity');
    Route::get('cost/type-activity/{type_activity}/details', 'CostController@getCostActivityDetails');

    Route::post('sale', 'SalesController@create');
    Route::get('sale/{farm_id}/{lot_id}', 'SalesController@index');
    Route::get('type-coffee-sale', 'SalesController@typeCoffeeSale');
    Route::post('report/cost', 'ReportController@costs');

    Route::get('cost/activity/{activity_id}', 'CostController@detailsByActivity');
    Route::get('cost/administrative/{type_category_id}', 'CostController@detailsByAdministrative');
    Route::post('report/last-registers', 'ReportController@lastRegisters');
    
});
Route::post('forgot', 'AuthController@forgot');
Route::post('reset', 'AuthController@reset');
