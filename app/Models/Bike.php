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
        'SerialNumber',
        'Description',
        'GearCount',
        'TireMaxPSI',
        'TireSize',
        'Color',
        'Class',
        'Brand',
        'BellHorn',
        'Reflectors',
        'Lights',
        'ID_Status'
    ];

    public $casts = [
        'BellHorn'   => 'boolean',
        'Reflectors' => 'boolean',
        'Lights'     => 'boolean'

    ];

    /**
     * Generate and apply the bike label using a max integer
     *
     * @param int $max
     */
    public function generateBikeLabel($max = 1)
    {
        $this->BikeLabel = ($this->Class ?? 'U') . '-' . $max;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(BikeHistory::class, 'ID_Bike', 'ID_Bike')
                    ->orderBy('CreateDateTime', 'desc')
                    ->limit(25);
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