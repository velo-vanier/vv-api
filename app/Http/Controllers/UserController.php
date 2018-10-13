<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * List all users in the system
     *
     * @param Request $request
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        return $this->userRepository->fetchAll($request->search, $request->filters);
    }

    /**
     * Get a user by ID
     *
     * @param $userId
     *
     * @return User
     */
    public function show($userId)
    {
        return $this->userRepository->fetchById($userId);
    }

    /**
     * Create a user in the system
     *
     * @param Request $request
     *
     * @return array
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Role'      => 'string|required|in:Staff,Volunteer,Borrower',
            'FirstName' => 'string|required|max:100',
            'LastName'  => 'string|required|max:100',
            'Email'     => 'email|required|max:100',
            'Phone'     => 'string|required|max:100',
            'Password'  => 'string|nullable|max:255',
            'ParentID'  => 'integer|nullable'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), '422');
        }

        try {
            return $this->userRepository->create($request->all());
        } catch (QueryException $e) {
            /*
            if ($e->getCode() == '23000') {
                return response(['error' => ['Duplicate key error']], '422');
            }
            */

            return response(['error' => [$e->getMessage()]], '422');
        }
    }

    /**
     * Update a user in the system
     *
     * @param         $userId
     * @param Request $request
     *
     * @return array
     */
    public function update($userId, Request $request)
    {
        return array_merge(['id' => $userId], $request->all());
    }
}