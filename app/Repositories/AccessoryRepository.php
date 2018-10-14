<?php

namespace App\Repositories;

use App\Models\Accessory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AccessoryRepository
{
    /**
     * Return a paginated list of all accessories in the system
     *
     * @return Collection
     */
    public function fetchAll()
    {
        return Accessory::paginate(25);
    }

    /**
     * Fetch a single accessory by ID
     *
     * @param $accessoryId
     *
     * @return Accessory
     */
    public function fetchById($accessoryId)
    {
        return Accessory::where('ID_Accessory', (int)$accessoryId)->firstOrFail();
    }

    /**
     * Create a new accessory
     *
     * @param array $payload
     *
     * @return Accessory
     */
    public function create(array $payload)
    {
        $accessory = new Accessory();
        $accessory->CreateDateTime = new Carbon();
        $accessory->fill($payload);
        $accessory->save();

        return $accessory->fresh();
    }

    /**
     * Update an accessory's details
     *
     * @param       $accessoryId
     * @param array $payload
     *
     * @return Accessory
     */
    public function update($accessoryId, array $payload)
    {
        $accessory = $this->fetchById($accessoryId);

        $accessory->fill($payload);
        $accessory->save();

        return $accessory->fresh();
    }
}