<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class JenisKegiatan extends Eloquent
{
	protected $collection = 'jenis_kegiatan';
    public $timestamps = false;

    protected $guarded = [];
}
