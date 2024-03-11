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
    'prefix' => '/seo-page',
    'namespace' => '\App\Http\Controllers'
], function ($router) {
    $router->group([
        'prefix' => 'example'
    ], function ($router) {
        $router->get('', 'ExampleSeoPageAdminController@index');
        $router->get('create', 'ExampleSeoPageAdminController@create');
        $router->get('{id}', 'ExampleSeoPageAdminController@show');
        $router->post('', 'ExampleSeoPageAdminController@store');
        $router->put('{id}', 'ExampleSeoPageAdminController@update');
        $router->delete('{id}', 'ExampleSeoPageAdminController@destroy');
    });
});
