<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserStatus extends Eloquent
{
	protected $collection = 'user_status';
    public $timestamps = false;

	public static function getstatus($kode){
		$getstatus = UserStatus::where('kode', (int)$kode)->where('status', 1)->get();

		if($getstatus->isEmpty()){
			$status = '';
		}else{
			$status = $getstatus[0]->name;
		}

		return $status;
	}
}
