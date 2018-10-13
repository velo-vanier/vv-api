<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'User';

    /**
     * Keys to hide from the payload
     *
     * @var array
     */
    public $hidden = [];
}