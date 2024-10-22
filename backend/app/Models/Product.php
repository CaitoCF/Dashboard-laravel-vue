<?php

namespace App\Models;

use Jenssegers\MongoDB\Eloquent\Model;

class Product extends Model
{
    protected $collection  = 'product';
    public $timestamps = false;
}
