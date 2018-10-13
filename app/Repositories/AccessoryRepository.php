<?php

namespace App\Repositories;

use App\Models\Accessory;
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
}