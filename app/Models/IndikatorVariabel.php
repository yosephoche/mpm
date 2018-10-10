<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class IndikatorVariabel extends Eloquent
{
	protected $collection = 'indikator_variabel';
    public $timestamps = false;

	public static function getvariabel($kode){
		$getvariabel = IndikatorVariabel::where('kode_variabel', $kode)->where('status', 1)->get();

		if($getvariabel->isEmpty()){
			$variabel = '';
		}else{
			$variabel = $getvariabel[0]->nama;
		}

		return $variabel;
	}

	public static function getVariabelIndividu(){
		$getvar = IndikatorVariabel::where('tingkat', '1')->where('pendaftaran', '1')->where('status', 1)->get();

		return $getvar;
	}

	public static function getVariabelRt(){
		$getvar = IndikatorVariabel::where('tingkat', '2')->where('pendaftaran', '1')->where('status', 1)->get();

		return $getvar;
	}

	public static function getVariabelAsset(){
		$getvar = IndikatorVariabel::where('tingkat', '3')->where('pendaftaran', '1')->where('status', 1)->get();

		return $getvar;
	}

	public static function getIndikatorVar($kode){
		$getvar = IndikatorVariabel::where('kode_variabel', $kode)->where('status', 1)->first();

		return $getvar;
	}


}
