<?php

namespace App\Models;

use Jenssegers\MongoDB\Eloquent\Model;

class Service extends Model
{
    protected $collection  = 'services';
    public $timestamps = false;
}
