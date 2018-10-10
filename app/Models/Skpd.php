<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Skpd extends Eloquent
{
	protected $collection = 'skpd';
    public $timestamps = false;

	public static function getskpd($kode){
		$getskpd = Skpd::where('kode', $kode)->where('status', 1)->get();

		if($getskpd->isEmpty()){
			$skpd = '';
		}else{
			$skpd = $getskpd[0]->name;
		}

		return $skpd;
	}
}
