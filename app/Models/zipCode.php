<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class zipCode extends Eloquent
{
    protected $collection = 'codes';
    protected $hidden = ['_id'];
}
