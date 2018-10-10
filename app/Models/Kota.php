<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Kota extends Eloquent
{
	protected $collection = 'kota';
    public $timestamps = false;

}
