<?php

Route::group(['prefix' => '/', 'namespace' => 'App\Modules\Front\Controllers'], function () {
	Route::group(['middleware' => 'web'], function(){
		//Route::group(['middleware'=>'auth:admins'], function(){
			//Route::get('/dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

			Route::get('/', ['as' => 'front.index', 'uses' => 'FrontController@index']);
			Route::get('/tentang', ['as' => 'front.about', 'uses' => 'FrontController@about']);

		//});
	});
});
