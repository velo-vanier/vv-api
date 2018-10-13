<?php

namespace App\Repositories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

class StatusRepository
{
    /**
     * Return a paginated list of all statuses in the system
     *
     * @return Collection
     */
    public function fetchAll()
    {
        return Status::paginate(25);
    }
}