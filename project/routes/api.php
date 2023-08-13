<?php

use Carbon\Carbon;
use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => ''], function ($router) {
    $router->group(['prefix' => 'users', 'namespace' => 'Users'], function () use ($router) {
        $router->post('', [
            'as' => 'api.users.store',
            'uses' => 'UserController@store'
        ]);

        $router->get('', [
            'as' => 'api.users.index',
            'uses' => 'UserController@index'
        ]);
    });

    $router->get('', [
        'as' => 'information',
        function () {
            return response([
                'title' => config('app.name'),
                'version' => '0.0.1',
                'timestamp' => Carbon::now()
            ]);
        }
    ]);
});