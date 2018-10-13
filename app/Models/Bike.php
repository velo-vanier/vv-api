<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    public $table = 'Bike';
    public $timestamps = false;

    protected $primaryKey = 'ID_Bike';

    /**
     * Set mass assignable attributes
     *
     * @var array
     */
    public $fillable = [
        'BikeLabel',
        'SerialNumber',
        'Description',
        'GearCount',
        'TireMaxPSI',
        'TireSize',
        'Color',
        'Class',
        'Brand',
        'ID_Status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(BikeHistory::class, 'ID_Bike', 'ID_Bike');
    }

    /**
     * Retrieve the photos attached to the bike
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function photos()
    {
        return $this->hasManyThrough(
            Photo::class,
            BikePhoto::class,
            'ID_Bike',
            'ID_Photo',
            'ID_Bike',
            'ID_Photo'
        );
    }
}