<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class JenisKegiatan extends Eloquent
{
	protected $collection = 'jenis_kegiatan';
    public $timestamps = false;

    protected $guarded = [];

    //get jenis kegiatan by name
    static public function getJenisKegiatanByName($idJenisKegiatan)
    {
        $jenis = JenisKegiatan::where('status', 1)->where('_id', $idJenisKegiatan)->first();

        if ($jenis) {
            $jenisKegiatan = $jenis->name;
        } else {
            $jenisKegiatan = '';
        }

        return $jenisKegiatan;
    }
}
