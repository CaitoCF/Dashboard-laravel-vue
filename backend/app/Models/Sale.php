<?php

namespace App\Models;

use Jenssegers\MongoDB\Eloquent\Model;

class Sale extends Model
{
    protected $collection  = 'sale';
    public $timestamps = false;
}
