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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => '/api/v1/site/seo-page',
    'namespace' => '\App\Http\Controllers'
], function (Route $router) {
    $router->group([
        'prefix' => 'catalog',
        'middleware' => 'auth'
    ], function (Route $router) {
        $router->get('', 'CatalogSeoPageAdminController@index');
        $router->get('create', 'CatalogSeoPageAdminController@create');
        $router->get('{id}', 'CatalogSeoPageAdminController@show');
        $router->post('', 'CatalogSeoPageAdminController@store');
        $router->put('{id}', 'CatalogSeoPageAdminController@update');
        $router->delete('{id}', 'CatalogSeoPageAdminController@destroy');
    });
});
