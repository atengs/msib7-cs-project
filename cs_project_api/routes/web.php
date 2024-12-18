<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api' ], function () use ($router) {

    // Master Categories
    $router->get('/master-categories', 'MasterCategoriesController@index');
    $router->get('/master-categories/getData', 'MasterCategoriesController@getData');
    $router->get('/master-categories/{id}', 'MasterCategoriesController@show');
    $router->post('/master-categories', 'MasterCategoriesController@store');
    $router->put('/master-categories/{id}', 'MasterCategoriesController@update');
    $router->delete('/master-categories/{id}', 'MasterCategoriesController@destroy');
    $router->get('/generateCode', 'MasterCategoriesController@generateCode');


    

    // Master Rate Card
    $router->get('/master-ratecard', 'MasterRatecardController@index');
    $router->get('/master-ratecard/getData', 'MasterRatecardController@getData');
    $router->get('/master-ratecard/{id}', 'MasterRatecardController@show');
    $router->post('/master-ratecard', 'MasterRatecardController@store');
    $router->put('/master-ratecard/{id}', 'MasterRatecardController@update');
    $router->delete('/master-ratecard/{id}', 'MasterRatecardController@destroy');
    $router->get('/master-job-category', 'MasterJobCategoryController@index');

    
    // Master Rate Card Standard
    $router->get('/master-ratecard-standard/indexx', 'MasterRatecardStandardController@index');
    $router->post('/master-ratecard-standard', 'MasterRatecardStandardController@store');
    $router->put('/master-ratecard-standard/{id}', 'MasterRatecardStandardController@update');
    $router->get('/master-ratecard-standard/filter-data', 'MasterRatecardStandardController@getFilterData');



    // Transaction Header
    $router->get('/trx-header', 'TransactionHeaderController@index');
    $router->post('/trx-header', 'TransactionHeaderController@store');
    $router->put('/trx-header/{id}', 'TransactionHeaderController@update');
    $router->delete('/trx-header/{id}', 'TransactionHeaderController@destroy');
    $router->get('/trx-header/getData', 'TransactionHeaderController@getData');
    $router->get('/trx-header/generate-code', 'TransactionHeaderController@generateCode');
    $router->get('/trx-header/{id}', 'TransactionHeaderController@show');
    $router->put('/trx-header/{id}/status', 'TransactionHeaderController@updateStatus');
    $router->post('/transaction/revision', 'TransactionHeaderController@saveRevision');

    // $router->get('/trx-header/generatePDF', 'TransactionHeaderController@generatePDF');

    // Transaction Detail
    $router->get('/trx-detail', 'TransactionDetailController@index');
    $router->post('/trx-detail', 'TransactionDetailController@store');

    // Revision Note
    $router->get('/revision', 'RevisionController@index');
    $router->post('/revision', 'RevisionController@store');


    // Invoice
    $router->get('/api/invoice/transaction-headers', 'InvoiceController@getTransactionHeaderData');
    $router->post('/invoice', 'InvoiceController@store');
    $router->get('/invoice/{id}', 'InvoiceController@show');

   

    // Check Out
    $router->get('/check-out', 'CheckOutController@index');
    $router->post('/check-out', 'CheckOutController@store');
    $router->put('/check-out/{id}', 'CheckOutController@update');
    $router->delete('/check-out/{id}', 'CheckOutController@destroy');
    $router->get('/check-out/getData', 'CheckOutController@getData');
    $router->get('/check-out/{id}', 'CheckOutController@show');

    

    // Doc Status
    $router->post('/storebulky', 'DocStatusController@storebulky');
    $router->post('/status', 'DocStatusController@store');
    $router->get('/status', 'DocStatusController@paging');
    $router->get('/status/{id}', 'DocStatusController@show');
    $router->put('/status/{id}', 'DocStatusController@update');
    $router->delete('/status/{id}', 'DocStatusController@destroy'); 


});














// $router->group(['prefix' => 'si' ], function () use ($router) {
//     $router->post('/storebulky', 'DocStatusController@storebulky');
//     $router->post('/status', 'DocStatusController@store');
//     $router->get('/status', 'DocStatusController@paging');
//     $router->get('/status/{id}', 'DocStatusController@show');
//     $router->put('/status/{id}', 'DocStatusController@update');
//     $router->delete('/status/{id}', 'DocStatusController@destroy');

// });


