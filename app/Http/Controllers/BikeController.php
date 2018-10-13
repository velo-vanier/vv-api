<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BikeController extends Controller
{
    /**
     * List all bikes in the system
     *
     * @return array
     */
    public function index()
    {
        return ['bikes' => []];
    }

    /**
     * Get a bike by ID
     *
     * @param $bikeId
     *
     * @return array
     */
    public function show($bikeId)
    {
        return ['id' => $bikeId];
    }

    /**
     * Create a bike in the system
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
     * Update a bike in the system
     *
     * @param         $userId
     * @param Request $request
     *
     * @return array
     */
    public function update($bikeId, Request $request)
    {
        return array_merge(['id' => $bikeId], $request->all());
    }
}