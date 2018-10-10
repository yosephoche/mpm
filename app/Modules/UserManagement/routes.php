<?php 

Route::group(['prefix' => '', 'namespace' => 'App\Modules\UserManagement\Controllers'], function () {
	Route::group(['middleware' => 'admin'], function(){
		//Route::group(['middleware'=>'auth:admins'], function(){
			//Route::get('/dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);
			
			Route::get('/globallogin', ['as' => 'usermanagement.globallogin', 'uses' => 'UserManagementController@index']);
			Route::post('/globallogin', ['as' => 'usermanagement.post.globallogin', 'uses' => 'UserManagementController@login']);
			Route::get('/logout', ['as' => 'usermanagement.logout', 'uses' => 'UserManagementController@logout']);
			
			Route::post('/sendemailforgot', ['as' => 'usermanagement.logout', 'uses' => 'UserManagementController@sendemailforgot']);
			Route::get('/reset-password/{id}/{token}', ['as' => 'usermanagement.resetpassword', 'uses' => 'UserManagementController@resetpassword']);
			Route::post('/reset-password', ['as' => 'usermanagement.resetpassword', 'uses' => 'UserManagementController@postresetpassword']);

		//});
	});
});