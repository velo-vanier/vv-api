<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    public $table = 'Bike';

    /**
     * Keys to hide from the payload
     *
     * @var array
     */
    public $hidden = [
        'ID_Status'
    ];

    /**
     * Additional properties to include in the response
     *
     * @var array
     */
    public $with = [
        'status'
    ];

    /**
     * Relationship with status table, using status ID
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'ID_Status', 'ID_Status');
    }
}