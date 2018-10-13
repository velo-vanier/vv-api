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
     * @var array
     */
    public $with = [
        'user',
        'staff',
        'accessories'
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
        return $this->belongsTo(User::class, 'ID_BikeUser', 'ID_User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'ID_StaffUser', 'ID_User');
    }

    /**
     * Retrieve the accessories attached to the bike history element
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function accessories()
    {
        return $this->hasManyThrough(
            Accessory::class,
            AccessoryHistory::class,
            'ID_BikeHistory',
            'ID_Accessory',
            'ID_BikeHistory',
            'ID_Assce'
        );
    }
}