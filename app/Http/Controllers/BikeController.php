<?php

namespace App\Http\Controllers;

use App\Repositories\BikeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BikeController extends Controller
{
    /**
     * @var BikeRepository
     */
    protected $bikeRepository;

    /**
     * BikeController constructor.
     *
     * @param BikeRepository $bikeRepository
     */
    public function __construct(BikeRepository $bikeRepository)
    {
        $this->bikeRepository = $bikeRepository;
    }

    /**
     * List all bikes in the system
     *
     * @return Collection
     */
    public function index()
    {
        return $this->bikeRepository->fetchAll();
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
        return $this->bikeRepository->fetchById($bikeId);
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