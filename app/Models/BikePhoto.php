<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BikePhoto extends Model
{
    public $table = 'BikePhoto';
    public $timestamps = false;

    protected $primaryKey = 'ID_BikePhoto';
}