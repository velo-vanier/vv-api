<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BikeHistory extends Model
{
    public $table = 'BikeHistory';
    public $timestamps = false;

    protected $primaryKey = 'ID_BikeHistory';

    public $hidden = [
        'ID_Bike'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bike()
    {
        return $this->belongsTo(Bike::class, 'ID_Bike', 'ID_Bike');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_User', 'ID_BikeUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'ID_User', 'ID_StaffUser');
    }

}