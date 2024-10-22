<?php

namespace App\Models;

use Jenssegers\MongoDB\Eloquent\Model;

class User extends Model
{
    protected $collection  = 'user';
    public $timestamps = false;
}
