<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $table = 'Status';

    /**
     * Column attributes to be returned
     *
     * @var array
     */
    public $attributes = [
        'ID_Status',
        'Name'
    ];
}