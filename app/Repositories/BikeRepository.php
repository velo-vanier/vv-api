<?php

namespace App\Repositories;

use App\Models\Bike;
use Illuminate\Database\Eloquent\Collection;

class BikeRepository
{
    /**
     * Return a paginated list of all bikes in the system
     *
     * @param string $search
     *
     * @return Collection
     */
    public function fetchAll($search = '', $filters = [])
    {
        $bike = new Bike();

        if ($search) {
            //if a search query is provided, look at the label, serial or description
            $bike = $bike->where(function ($q) use ($search) {
                $q->where('BikeLabel', 'LIKE', '%' . $search . '%')
                  ->orWhere('SerialNumber', 'LIKE', '%' . $search . '%')
                  ->orWhere('Description', 'LIKE', '%' . $search . '%');
            });
        }

        if ($filters) {
            foreach ($filters as $key => $value) {
                switch ($key) {
                    case 'ID_User':
                        $bike = $bike->whereHas('history', function ($q) use ($value) {
                            $q->where('ID_BikeUser', $value);
                        });
                        break;
                }
            }
        }

        return $bike->paginate(25);
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
        return Bike::with(['history', 'photos'])->where('ID_Bike', (int)$bikeId)->firstOrFail();
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