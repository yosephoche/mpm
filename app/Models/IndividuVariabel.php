<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class IndividuVariabel extends Eloquent
{
	protected $collection = 'individu_variabel';
    public $timestamps = false;

    protected $guarded = [];
}
