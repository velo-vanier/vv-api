<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $table = 'Photo';
    public $timestamps = false;

    protected $primaryKey = 'ID_Photo';
}