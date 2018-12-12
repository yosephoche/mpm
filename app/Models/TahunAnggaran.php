<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class TahunAnggaran extends Eloquent
{
	protected $collection = 'tahun_anggaran';
    public $timestamps = false;
}
