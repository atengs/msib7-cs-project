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


$router->group(['prefix' => '/api'], function () use ($router) {
    $router->group(['prefix' => '/mst-category'], function () use ($router) {
        $router->get('/', 'MasterCategoriesController@index');
        $router->get('/getById/{id}', 'MasterCategoriesController@show');
        $router->get('/getData', 'MasterCategoriesController@getData');
        $router->post('/', 'MasterCategoriesController@store');
        $router->get('/generateCode', 'MasterCategoriesController@generateCode');
        $router->put('/update/{id}', 'MasterCategoriesController@update');
        $router->delete('/delete/{id}', 'MasterCategoriesController@destroy');
    });
    $router->group(['prefix' => '/mst-job-category'], function () use ($router) {
        $router->get('/', 'MasterJobCategoryController@index');
        $router->get('/getById/{id}', 'MasterJobCategoryController@show');
        $router->get('/getData', 'MasterJobCategoryController@getData');
        $router->post('/', 'MasterJobCategoryController@store');
    });
    $router->group(['prefix' => '/mst-joblist'], function () use ($router) {
        $router->get('/', 'MasterJoblistController@index');
        $router->get('/getById/{id}', 'MasterJoblistController@show');
        $router->get('/getData', 'MasterJoblistController@getData');
        $router->post('/', 'MasterJoblistController@store');
        $router->put('/update/{id}', 'MasterJoblistController@update');
        $router->delete('/delete/{id}', 'MasterJoblistController@destroy');
    });
});