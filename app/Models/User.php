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

    /**
     * Retrieve the photos attached to the user
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