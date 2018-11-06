<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PesertaMpm extends Eloquent
{
	protected $collection = 'peserta_mpm';
    public $timestamps = false;

    public static function getcountpeserta(){
        $getcount = PesertaMpm::where('verifikasi', 1)->where('status', 1)->count();

        return $getcount;
    }

    public static function getkrt($kodepeserta){
    	$getkrt = PesertaMpm::where('kodepeserta', $kodepeserta)->where('individu.b4_k3', '1')->first();

        return $getkrt->individu;
    }

    public static function getnamakrt($kodepeserta){
        $getkrt = PesertaMpm::where('kodepeserta', $kodepeserta)->where('individu.b4_k3', '1')->get();

        if($getkrt->isEmpty()){
            $var = '';
        }else{
            $var = $getkrt[0]->individu[0]['nama'];
        }

        return $var;
    }

	public static function getskrining($kodepeserta){
		$getindi1 = count(PesertaMpm::where('status', 1)->where('kodepeserta', $kodepeserta)->where('datart.b3_k5a', '1')->get()) == 0 ? 0 : 1;
		$getindi2 = count(PesertaMpm::where('status', 1)->where('kodepeserta', $kodepeserta)->where('pendidikanart', '<=', '4')->get()) == 0 ? 1 : 0;
		$getindi3 = count(PesertaMpm::where('status', 1)->where('kodepeserta', $kodepeserta)->where('asset.b5_k1k', '1')->get()) == 0 ? 0 : 1;
		$getindi4 = count(PesertaMpm::where('status', 1)->where('kodepeserta', $kodepeserta)->where('asset.b5_k1c', '1')->get()) == 0 ? 0 : 1;
		$getindi5 = count(PesertaMpm::where('status', 1)->where('kodepeserta', $kodepeserta)->where('asset.b5_k1a', '1')->get()) == 0 ? 0 : 1;

		$getindi = $getindi1 + $getindi2 + $getindi3 + $getindi4 + $getindi5;

		if($getindi < 3){
			return false;
		}else{
			return true;
		}
	}

	public static function getvalue($kodepeserta, $sublist, $kodevariabel){
		$getvar = PesertaMpm::where('kodepeserta', $kodepeserta)->where('status', 1)->get();

		if($getvar->isEmpty()){
			$var = '';
		}else{
			if (array_key_exists($kodevariabel, $getvar[0]->$sublist)){
				$var = $getvar[0]->$sublist[0][$kodevariabel];
			}else{
				$var = '';
			}
		}

		return $var;
	}
}
