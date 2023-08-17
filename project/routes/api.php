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
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('', [
                'as' => 'api.users.store',
                'uses' => 'UserController@store'
            ]);
    
            $router->get('', [
                'as' => 'api.users.index',
                'uses' => 'UserController@index'
            ]);
    
            $router->get('{uuid}', [
                'as' => 'api.users.show',
                'uses' => 'UserController@show'
            ]);
    
            $router->put('{uuid}', [
                'as' => 'api.users.update',
                'uses' => 'UserController@update'
            ]);
    
            $router->delete('{uuid}', [
                'as' => 'api.users.destroy',
                'uses' => 'UserController@destroy'
            ]);

            $router->post('logout', [
                'as' => 'api.users.logout',
                'uses' => 'UserController@logout'
            ]);
        });

        $router->post('login', [
            'as' => 'api.users.login',
            'uses' => 'UserController@login'
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