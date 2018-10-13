<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    /**
     * Return a paginated list of all users in the system
     *
     * @return Collection
     */
    public function fetchAll()
    {
        return User::paginate(25);
    }

    /**
     * Fetch a single user by ID
     *
     * @param $userId
     *
     * @return User
     */
    public function fetchById($userId)
    {
        return User::where('ID_User', (int)$userId)->firstOrFail();
    }
}