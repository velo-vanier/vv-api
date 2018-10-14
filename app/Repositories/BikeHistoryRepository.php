<?php

namespace App\Repositories;

use App\Models\BikeHistory;
use Carbon\Carbon;

class BikeHistoryRepository
{
    /**
     * Create a new bike history element
     *
     * @param      $bikeId
     * @param      $status
     * @param null $bikeUserId
     * @param null $staffUserId
     *
     * @return BikeHistory
     */
    public function create($bikeId, $status, $bikeUserId = null, $staffUserId = null)
    {
        $bikeHistory                 = new BikeHistory();
        $bikeHistory->CreateDateTime = new Carbon();
        $bikeHistory->ID_Status      = $status;
        $bikeHistory->ID_Bike        = $bikeId;
        $bikeHistory->ID_BikeUser    = $bikeUserId;
        $bikeHistory->ID_StaffUser   = $staffUserId;

        $bikeHistory->save();

        return $bikeHistory->fresh();
    }

    /**
     * Update the return date for a history item
     *
     * @param BikeHistory $bikeHistory
     *
     * @return BikeHistory
     */
    public function updateReturnDate(BikeHistory $bikeHistory)
    {
        $bikeHistory->ReturnDateTime = new Carbon();
        $bikeHistory->save();

        return $bikeHistory->fresh();
    }

    /**
     * Update the due date for a history item
     *
     * @param BikeHistory $bikeHistory
     * @param             $dueDateTime
     *
     * @return BikeHistory
     */
    public function updateDueDate(BikeHistory $bikeHistory, $dueDateTime)
    {
        $bikeHistory->DueDateTime = $dueDateTime;
        $bikeHistory->save();

        return $bikeHistory->fresh();
    }
}