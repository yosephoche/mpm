<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Kelurahan extends Eloquent
{
	protected $collection = 'kelurahan';
    public $timestamps = false;

	public static function getkelurahan($id){
		$getkel = Kelurahan::where('id_kelurahan', $id)->where('status', true)->get();

		if($getkel->isEmpty()){
			$kelurahan = '';
		}else{
			$kelurahan = $getkel[0]->kelurahan;
		}

		return $kelurahan;
	}
}
