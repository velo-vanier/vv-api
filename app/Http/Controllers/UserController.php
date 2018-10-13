<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List all users in the system
     *
     * @return array
     */
    public function index()
    {
        return ['users' => []];
    }

    /**
     * Get a user by ID
     *
     * @param $userId
     *
     * @return array
     */
    public function show($userId)
    {
        return ['id' => $userId];
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