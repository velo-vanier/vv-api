<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Repositories\AccessoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AccessoryController extends Controller
{
    /**
     * @var AccessoryRepository
     */
    protected $accessoryRepository;

    /**
     * AccessoryRepository constructor.
     *
     * @param AccessoryRepository $accessoryRepository
     */
    public function __construct(AccessoryRepository $accessoryRepository)
    {
        $this->accessoryRepository = $accessoryRepository;
    }

    /**
     * List all accessories in the system
     *
     * @return Collection
     */
    public function index()
    {
        return $this->accessoryRepository->fetchAll();
    }

    /**
     * Get a accessory by ID
     *
     * @param $accessoryId
     *
     * @return Accessory
     */
    public function show($accessoryId)
    {
        return $this->accessoryRepository->fetchById($accessoryId);
    }

    /**
     * Create an accessory in the system
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
     * Update an accessory in the system
     *
     * @param         $accessoryId
     * @param Request $request
     *
     * @return array
     */
    public function update($accessoryId, Request $request)
    {
        return array_merge(['id' => $accessoryId], $request->all());
    }
}