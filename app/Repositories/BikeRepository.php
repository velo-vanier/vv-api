<?php

namespace App\Repositories;

use App\Models\Bike;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BikeRepository
{
    /**
     * Return a paginated list of all bikes in the system
     *
     * @param string $search
     * @param array  $filters
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
                switch (strtolower($key)) {
                    case 'id_user':
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
        //get the expected identifier for the bike
        $max = array_get(Bike::select(DB::raw('max(ID_Bike) as id'))->first()->toArray(), 'id', 1) + 1;

        $bike = new Bike();
        $bike->fill($payload);

        $bike->generateBikeLabel($max);

        $bike->save();

        return $bike->fresh();
    }
}