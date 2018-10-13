<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoryHistory extends Model
{
    public $table = 'AccessoryHistory';
    public $timestamps = false;

    protected $primaryKey = 'ID_AccHistory';
}