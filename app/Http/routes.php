<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'as'=>'chips.home',
    function () {
        return view('home');
}]);

Route::get('/fetch',[
   'uses' => 'MainController@getFetchSkills',
    'as' => 'chips.fetch'
]);

Route::post('/save',[
        'uses' => 'MainController@postSaveSkills',
        'as' => 'chips.save'
]);