<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    public $table = 'UserPhoto';
    public $timestamps = false;

    protected $primaryKey = 'ID_UserPhoto';
}