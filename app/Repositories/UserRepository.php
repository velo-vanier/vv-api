<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    /**
     * Return a paginated list of all users in the system
     *
     * @param string $search
     * @param array  $filters
     *
     * @return Collection
     */
    public function fetchAll($search = '', $filters = [])
    {
        $user = new User();

        if ($search) {
            $user = $user->where(function ($q) use ($search) {
                //if a search query is provided, look at the name, email, phone
                $q->where('FirstName', 'LIKE', '%' . $search . '%')
                  ->orWhere('LastName', 'LIKE', '%' . $search . '%')
                  ->orWhere('Email', 'LIKE', '%' . $search . '%')
                  ->orWhere('Phone', 'LIKE', '%' . $search . '%');
            });
        }

        if ($filters) {
            foreach ($filters as $key => $value) {
                switch (strtolower($key)) {
                    case 'role':
                        $user = $user->where('Role', $value);
                        break;
                }
            }
        }

        return $user->paginate(25);
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
        return User::with(['history', 'photos'])->where('ID_User', (int)$userId)->firstOrFail();
    }
}