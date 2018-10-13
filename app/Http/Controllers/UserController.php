<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
        return $this->userRepository->fetchAll($request->search);
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
        return $request->all();
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