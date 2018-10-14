<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Repositories\AccessoryRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

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
     * @return Accessory
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ID_Type'     => 'integer|required|max:100',
            'ID_Status'   => 'integer|required|max:4',
            'Name'        => 'string|required|max:50',
            'Description' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), '422');
        }

        try {
            return $this->accessoryRepository->create($request->all());
        } catch (QueryException $e) {
            return response(['error' => [$e->getMessage()]], '422');
        }
    }

    /**
     * Update a accessory in the system
     *
     * @param         $accessoryId
     * @param Request $request
     *
     * @return Accessory
     */
    public function update($accessoryId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ID_Type'     => 'integer|required|max:100',
            'ID_Status'   => 'integer|required|max:4',
            'Name'        => 'string|required|max:50',
            'Description' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), '422');
        }

        try {
            return $this->accessoryRepository->update($accessoryId, $request->all());
        } catch (QueryException $e) {
            return response(['error' => [$e->getMessage()]], '422');
        }
    }
}