<?php

Route::group(['prefix' => '/', 'namespace' => 'App\Modules\Dashboard\Controllers'], function () {
	Route::group(['middleware' => 'admin'], function(){
		Route::group(['middleware'=>'auth:admin'], function(){
			//Route::get('/dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

			Route::get('/dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

			Route::get('/mpm/registrasi', ['as' => 'dashboard.mpm.index', 'uses' => 'MpmController@index']);
			Route::post('/mpm/registrasi', ['as' => 'dashboard.mpm.postregistrasi', 'uses' => 'MpmController@postregistrasi']);
			Route::get('/mpm', ['as' => 'dashboard.mpm.listmpm', 'uses' => 'MpmController@listmpm']);
			Route::get('/getpesertaterdaftar', ['as' => 'dashboard.mpm.getpesertaterdaftar', 'uses' => 'MpmController@getpesertaterdaftar']);
			Route::get('/mpm/update/{idpeserta}', ['as' => 'dashboard.mpm.update', 'uses' => 'MpmController@update']);
			Route::post('/mpm/update', ['as' => 'dashboard.mpm.postupdate', 'uses' => 'MpmController@postupdate']);
			Route::get('/mpm/delete/{idpeserta}', ['as' => 'dashboard.mpm.delete', 'uses' => 'MpmController@delete']);
			Route::get('/mpm/detail/{idpeserta}', ['as' => 'dashboard.mpm.detail', 'uses' => 'MpmController@detail']);

			Route::get('/ppfm/peserta-baru', ['as' => 'dashboard.ppfm.peserta.baru', 'uses' => 'PpfmController@newpeserta']);
			Route::get('/ppfm/verifikasi/{idpeserta}', ['as' => 'dashboard.ppfm.verifikasi', 'uses' => 'PpfmController@newverification']);
			Route::get('/ppfm/peserta-lama', ['as' => 'dashboard.ppfm.peserta.lama', 'uses' => 'PpfmController@oldpeserta']);
			Route::post('/ppfm/peserta-lama', ['as' => 'dashboard.ppfm.peserta.lama', 'uses' => 'PpfmController@postoldpeserta']);
			Route::get('/ppfm/peserta-lama/delete/{idpeserta}', ['as' => 'dashboard.ppfm.peserta.lama.delete', 'uses' => 'PpfmController@deloldpeserta']);
			Route::get('/ppfm/verifikasi/{idpeserta}', ['as' => 'dashboard.ppfm.verifikasi', 'uses' => 'PpfmController@newverification']);
			Route::post('/ppfm/verifikasi/', ['as' => 'dashboard.ppfm.verifikasi', 'uses' => 'PpfmController@postnewverification']);
			Route::post('/ppfm/regverif/individu', ['as' => 'dashboard.ppfm.postverifindividu', 'uses' => 'PpfmController@postregverifindividu']);
			Route::post('/ppfm/updateverif/individu', ['as' => 'dashboard.ppfm.postupdateindividu', 'uses' => 'PpfmController@postupdateverifindividu']);
			Route::get('/delete/pesertaverifindividu', ['as' => 'dashboard.peserta.individu', 'uses' => 'PpfmController@delpesertaverifindividu']);
			Route::get('/ppfm/peserta-baru/delete/{idpeserta}', ['as' => 'dashboard.ppfm.peserta.baru.delete', 'uses' => 'PpfmController@delnewpeserta']);
			
			Route::get('/ppfm/perubahan/{idpeserta}', ['as' => 'dashboard.ppfm.perubahan', 'uses' => 'PpfmController@updateverification']);
			Route::post('/ppfm/registrasi/individu', ['as' => 'dashboard.ppfm.postregistrasiindividu', 'uses' => 'PpfmController@postregistrasiindividu']);
			Route::get('/delete/pesertaindividu', ['as' => 'dashboard.peserta.individu', 'uses' => 'PpfmController@delpesertaindividu']);
			Route::post('/ppfm/update/individu', ['as' => 'dashboard.ppfm.postupdateindividu', 'uses' => 'PpfmController@postupdateindividu']);
			
			Route::post('/ppfm/registrasinew/individu/tanggungan', ['as' => 'dashboard.ppfm.postindividutanggungan', 'uses' => 'PpfmController@postnewindividutanggungan']);
			Route::get('/delete/newpesertatanggungan', ['as' => 'dashboard.peserta.delete.tanggungan', 'uses' => 'PpfmController@delnewpesertatanggungan']);
			Route::post('/ppfm/newupdate/individu/tanggungan', ['as' => 'dashboard.ppfm.postupdatetanggungan', 'uses' => 'PpfmController@postnewupdatetanggungan']);

			Route::post('/ppfm/registrasi/individu/tanggungan', ['as' => 'dashboard.ppfm.postindividutanggungan', 'uses' => 'PpfmController@postindividutanggungan']);
			Route::get('/delete/pesertatanggungan', ['as' => 'dashboard.peserta.delete.tanggungan', 'uses' => 'PpfmController@delpesertatanggungan']);
			Route::post('/ppfm/update/individu/tanggungan', ['as' => 'dashboard.ppfm.postupdatetanggungan', 'uses' => 'PpfmController@postupdatetanggungan']);

			Route::get('/ppfm/cetak-peserta-baru', ['as' => 'dashboard.ppfm.cetakpesertabaru', 'uses' => 'PpfmController@cetakpesertabaru']);
			Route::get('/ppfm/cetak-peserta-lama', ['as' => 'dashboard.ppfm.cetakpesertalama', 'uses' => 'PpfmController@cetakpesertalama']);

			Route::get('/getkota/{idprov}', ['as' => 'dashboard.mpm.getkota', 'uses' => 'MpmController@getkota']);
			Route::get('/getkecamatan/{idkota}', ['as' => 'dashboard.mpm.getkecamatan', 'uses' => 'MpmController@getkecamatan']);
			Route::get('/getkelurahan/{idkec}', ['as' => 'dashboard.mpm.getkelurahan', 'uses' => 'MpmController@getkelurahan']);
			Route::get('/getopsiindi/{idvar}', ['as' => 'dashboard.mpm.getopsiindi', 'uses' => 'MasterController@getopsiindi']);

			Route::get('/pengguna', ['as' => 'dashboard.user.pengguna', 'uses' => 'UserController@listpengguna']);

			Route::get('/pengaturan/pengguna', ['as' => 'dashboard.user.pengaturan.pengguna', 'uses' => 'UserController@pengaturanpengguna']);
			Route::post('/pengaturan/pengguna', ['as' => 'dashboard.user.pengaturan.pengguna', 'uses' => 'UserController@postpengaturanpengguna']);

			Route::get('/pengguna/registrasi', ['as' => 'dashboard.user.registrasi', 'uses' => 'UserController@index']);
			Route::post('/pengguna/registrasi', ['as' => 'dashboard.user.postregistrasi', 'uses' => 'UserController@registrasi']);
			Route::get('/pengguna/hapus/{iduser}', ['as' => 'dashboard.user.hapus', 'uses' => 'UserController@delete']);

			Route::get('/pengguna/update/{iduser}', ['as' => 'dashboard.user.update', 'uses' => 'UserController@update']);
			Route::post('/pengguna/update', ['as' => 'dashboard.user.postupdate', 'uses' => 'UserController@postupdate']);
			Route::post('/pengguna/update/password', ['as' => 'dashboard.user.updatepassword', 'uses' => 'UserController@updatepassword']);

			Route::get('/induk/individu', ['as' => 'dashboard.bdt.index', 'uses' => 'IndukController@index']);
			Route::get('/induk/individu/detail/{idpeserta}', ['as' => 'dashboard.bdt.individu.detail', 'uses' => 'IndukController@individudetail']);
			Route::get('/induk/individu/detail/art/{kodepeserta}/{idpeserta}', ['as' => 'dashboard.bdt.individu.detail.art', 'uses' => 'IndukController@individudetailart']);

			Route::get('/induk/rumahtangga', ['as' => 'dashboard.bdt.index', 'uses' => 'IndukController@indexrt']);
			Route::get('/induk/rumahtangga/detail/{kodepeserta}', ['as' => 'dashboard.bdt.rt.detail', 'uses' => 'IndukController@rumahtanggadetail']);


			Route::get('/getsummary', ['as' => 'dashboard.bdt.rt.detail', 'uses' => 'DashboardController@getsummary']);

		});
	});
});

Route::group(['prefix' => '/master', 'namespace' => 'App\Modules\Dashboard\Controllers'], function () {
	Route::group(['middleware' => 'admin'], function(){
		Route::group(['middleware'=>'auth:admin'], function(){
			//Route::get('/dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

			Route::get('/indikator/variabel', ['as' => 'dashboard.master.indikator.variabel', 'uses' => 'MasterController@listindivariabel']);

			Route::get('/indikator/variabel/input', ['as' => 'dashboard.master.indikator.variabel.input', 'uses' => 'MasterController@indivariabel']);
			Route::post('/indikator/variabel/input', ['as' => 'dashboard.master.indikator.variabel.input.post', 'uses' => 'MasterController@postindivariabel']);

			Route::get('/indikator/variabel/delete/{idvar}', ['as' => 'dashboard.master.indikator.variabel.delete', 'uses' => 'MasterController@indivariabeldelete']);

			Route::get('/indikator/variabel/update/{idvar}', ['as' => 'dashboard.master.indikator.variabel.update', 'uses' => 'MasterController@indivariabelupdate']);
			Route::post('/indikator/variabel/update', ['as' => 'dashboard.master.indikator.variabel.postupdate', 'uses' => 'MasterController@indivariabelpostupdate']);

			Route::get('/indikator/opsi', ['as' => 'dashboard.master.indikator.opsi', 'uses' => 'MasterController@listindiopsi']);

			Route::get('/indikator/opsi/input', ['as' => 'dashboard.master.indikator.opsi', 'uses' => 'MasterController@indiopsi']);
			Route::post('/indikator/opsi/input', ['as' => 'dashboard.master.indikator.indi.post', 'uses' => 'MasterController@postindiopsi']);

			Route::get('/indikator/opsi/delete/{idvar}', ['as' => 'dashboard.master.indikator.opsi.delete', 'uses' => 'MasterController@indiopsidelete']);

			Route::get('/indikator/opsi/update/{idvar}', ['as' => 'dashboard.master.indikator.opsi.update', 'uses' => 'MasterController@indiopsiupdate']);
			Route::post('/indikator/opsi/update', ['as' => 'dashboard.master.indikator.opsi.postupdate', 'uses' => 'MasterController@indiopsipostupdate']);
		});
	});
});