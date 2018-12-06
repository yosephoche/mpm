<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class IndikatorKegiatan extends Eloquent
{
	protected $collection = 'indikator_kategori';
    public $timestamps = false;

    protected $guarded = [];
}
