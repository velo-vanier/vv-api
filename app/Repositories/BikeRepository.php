<?php

namespace App\Repositories;

use App\Models\Bike;
use Illuminate\Database\Eloquent\Collection;

class BikeRepository
{
    /**
     * Return a paginated list of all bikes in the system
     *
     * @return Collection
     */
    public function fetchAll()
    {
        return Bike::paginate(25);
    }

    /**
     * Fetch a single bike by ID
     *
     * @param $bikeId
     *
     * @return Bike
     */
    public function fetchById($bikeId)
    {
        return Bike::where('ID_Bike', (int)$bikeId)->firstOrFail();
    }

    /**
     * @param array $payload
     *
     * @return Bike
     */
    public function create(array $payload)
    {
        $bike = new Bike();
        $bike->fill($payload);
        $bike->save();

        return $bike->fresh();
    }
}