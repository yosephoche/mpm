<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Kecamatan extends Eloquent
{
	protected $collection = 'kecamatan';
    public $timestamps = false;

	public static function getkecamatan($id){
		$getkec = Kecamatan::where('id_kecamatan', $id)->where('status', true)->get();

		if($getkec->isEmpty()){
			$kecamatan = '';
		}else{
			$kecamatan = $getkec[0]->kecamatan;
		}

		return $kecamatan;
	}

	public static function countpeserta($kecamatan){
		$peserta1 = PesertaBDT::where('kab', '7316')->where('kec', $kecamatan)->where('status', 1)->count();

		$peserta2 = PesertaMpm::where('kab', '7316')->where('kec', $kecamatan)->where('verifikasi', 1)->where('status', 1)->count();

		$peserta3 = $peserta1 + $peserta2;
		return $peserta3;
	}
}
