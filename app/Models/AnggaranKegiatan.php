<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AnggaranKegiatan extends Eloquent
{
	protected $collection = 'anggaran_kegiatan';
    public $timestamps = false;

    protected $guarded = [];
}
