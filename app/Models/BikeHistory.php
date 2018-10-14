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

    public $fillable = [
        'LoanDateTime',
        'DueDateTime',
        'ReturnDateTime'
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
     * @var array
     */
    public $dates = [
        'CreateDateTime',
        'LoanDateTime',
        'DueDateTime',
        'ReturnDateTime'
    ];

    /**
     * Determine if a state change is allowed.
     *
     * This checks the current history status against the incoming status.
     *
     * @param $newStatus
     *
     * @return bool
     */
    public function isStatusChangeAllowed($newStatus)
    {
        switch ($this->ID_Status) {
            case Status::STATUS_AVAILABLE:
                $allowedStatuses = [
                    Status::STATUS_ONHOLD,
                    Status::STATUS_ONLOAN,
                    Status::STATUS_MIA,
                    Status::STATUS_SCRAPPED,
                    Status::STATUS_GIVENAWAY
                ];
                break;
            case Status::STATUS_ONLOAN:
                $allowedStatuses = [
                    Status::STATUS_INTEST,
                    Status::STATUS_MIA
                ];
                break;
            case Status::STATUS_ONHOLD:
                $allowedStatuses = [
                    Status::STATUS_AVAILABLE,
                    Status::STATUS_ONLOAN
                ];
                break;
            case Status::STATUS_INTEST:
                $allowedStatuses = [
                    Status::STATUS_AVAILABLE,
                    Status::STATUS_INREPAIR
                ];
                break;
            case Status::STATUS_INREPAIR:
                $allowedStatuses = [
                    Status::STATUS_INTEST,
                    Status::STATUS_AVAILABLE,
                    Status::STATUS_SCRAPPED
                ];
                break;
            default:
            case Status::STATUS_MIA:
            case Status::STATUS_SCRAPPED:
            case Status::STATUS_GIVENAWAY:
                $allowedStatuses = [];
                break;
        }

        return in_array((int)$newStatus, $allowedStatuses);
    }

    /**
     * Based on a status, determine if a due date field is required
     *
     * @param $status
     *
     * @return bool
     */
    public function isDueDateRequired($newStatus)
    {
        return in_array($newStatus, [Status::STATUS_ONLOAN]);
    }

    /**
     * Determine if the return date needs to be set
     *
     * @param $status
     *
     * @return bool
     */
    public function isReturnDateRequired($status)
    {
        return ($this->ID_Status == Status::STATUS_ONLOAN) && ($status == Status::STATUS_INTEST);
    }

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