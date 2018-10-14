<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    public $table = 'Accessory';
    public $timestamps = false;

    protected $primaryKey = 'ID_Accessory';

    /**
     * Set mass assignable attributes
     *
     * @var array
     */
    public $fillable = [
        'ID_Type',
        'ID_Status',
        'Name',
        'Description'
    ];
}