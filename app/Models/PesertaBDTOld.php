<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PesertaBDTOld extends Eloquent
{
	protected $collection = 'peserta_bdt_old';
    public $timestamps = false;

    public static function getcountart($kode){
    	$getcart = PesertaIndividu::where('kodepeserta', $kode)->where('status', 1)->get();

    	return $getcart->count();
    }
}
