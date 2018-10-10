<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OpsiIndikator extends Eloquent
{
	protected $collection = 'opsi_indikator';
    public $timestamps = false;

	public static function getopsi($kode){
		$indi = OpsiIndikator::where('kode_variabel', $kode)->where('status', 1)->get();
		return $indi;
	}

	public static function getopsiindi($kode, $opsiindi){
		$indi = OpsiIndikator::where('kode_variabel', $kode)->where('opsi_indi', $opsiindi)->where('status', 1)->get();
		return $indi;
	}

	public static function getopsivar($kode, $no_opsi){
		$getopsi = OpsiIndikator::where('kode_variabel', $kode)->where('no_opsi', $no_opsi)->where('status', 1)->get();

		if($getopsi->isEmpty()){
			$getisi = IndikatorVariabel::where('kode', $kode)->where('caraisi', '1')->where('status', 1)->get();
			if($getisi->isEmpty()){
				$opsi = '';
			}else{
				$opsi = $no_opsi;			
			}
		}else{
			$opsi = $getopsi[0]->no_opsi.'. '.$getopsi[0]->desc_opsi;
		}

		return $opsi;
	}

	public static function getopsivarsub($kode, $no_opsi, $opsi_indi){
		$getopsi = OpsiIndikator::where('kode_variabel', $kode)->where('no_opsi', $no_opsi)->where('opsi_indi', $opsi_indi)->where('status', 1)->get();

		if($getopsi->isEmpty()){
			$opsi = '';
		}else{
			$opsi = ' ('.$getopsi[0]->no_opsi.'. '.$getopsi[0]->desc_opsi.')';
		}

		return $opsi;
	}
}
