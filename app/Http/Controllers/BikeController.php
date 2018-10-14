<?php

namespace App\Http\Controllers;

use App\Exceptions\BikeHistoryException;
use App\Models\Bike;
use App\Repositories\BikeRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    {
        return $this->bikeRepository->fetchAll($request->search, $request->filters);
    }

    /**
     * Get a bike by ID
     *
     * @param $bikeId
     *
     * @return Bike
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
     * @return Bike
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'SerialNumber' => 'string|required|max:64',
            'Description'  => 'string|required|max:128',
            'GearCount'    => 'integer|required',
            'TireMaxPSI'   => 'integer|required',
            'TireSize'     => 'string|nullable|max:45',
            'Color'        => 'string|nullable|max:45',
            'Class'        => 'string|nullable|max:45',
            'Brand'        => 'string|nullable|max:45',
            'BellHorn'     => 'boolean|nullable',
            'Reflectors'   => 'boolean|nullable',
            'Lights'       => 'boolean|nullable',
            'ID_Status'    => 'integer|required'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), '422');
        }

        try {
            return $this->bikeRepository->create($request->all());
        } catch (QueryException $e) {
            return response(['error' => [$e->getMessage()]], '422');
        }
    }

    /**
     * Update a bike in the system
     *
     * @param         $userId
     * @param Request $request
     *
     * @return Bike
     */
    public function update($bikeId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Description'    => 'string|required|max:128',
            'GearCount'      => 'integer|required',
            'TireMaxPSI'     => 'integer|required',
            'TireSize'       => 'string|nullable|max:45',
            'Color'          => 'string|nullable|max:45',
            'Class'          => 'string|nullable|max:45',
            'Brand'          => 'string|nullable|max:45',
            'BellHorn'       => 'boolean|nullable',
            'Reflectors'     => 'boolean|nullable',
            'Lights'         => 'boolean|nullable',
            'ID_Status'      => 'integer|required',
            'LoanDateTime'   => 'date|nullable',
            'DueDateTime'    => 'date|nullable',
            'ReturnDateTime' => 'date|nullable'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), '422');
        }

        try {
            return $this->bikeRepository->update($bikeId, $request->all());
        } catch (QueryException $e) {
            return response(['error' => [$e->getMessage()]], '422');
        } catch (BikeHistoryException $e) {
            return response(['history' => [$e->getMessage()]], '422');
        }
    }
}