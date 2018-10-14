<?php

namespace App\Repositories;

use App\Exceptions\InvalidDueDateException;
use App\Exceptions\InvalidStatusChangeException;
use App\Models\Bike;
use App\Models\BikeHistory;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BikeRepository
{
    /**
     * @var BikeHistoryRepository
     */
    protected $bikeHistoryRepository;

    /**
     * BikeRepository constructor.
     *
     * @param BikeHistoryRepository $bikeHistoryRepository
     */
    public function __construct(BikeHistoryRepository $bikeHistoryRepository)
    {
        $this->bikeHistoryRepository = $bikeHistoryRepository;
    }

    /**
     * Return a paginated list of all bikes in the system
     *
     * @param string $search
     * @param array  $filters
     *
     * @return Collection
     */
    public function fetchAll($search = '', $filters = [])
    {
        $bike = new Bike();

        if ($search) {
            //if a search query is provided, look at the label, serial or description
            $bike = $bike->where(function ($q) use ($search) {
                $q->where('BikeLabel', 'LIKE', '%' . $search . '%')
                  ->orWhere('SerialNumber', 'LIKE', '%' . $search . '%')
                  ->orWhere('Description', 'LIKE', '%' . $search . '%');
            });
        }

        if ($filters) {
            foreach ($filters as $key => $value) {
                switch (strtolower($key)) {
                    case 'id_user':
                        //get the children ids for the user
                        $children = User::select('ID_User')->where('ParentId', $value)->get()->toArray();

                        $bike = $bike->whereHas('currentHistory', function ($q) use ($value, $children) {
                            $q->where('ID_BikeUser', $value);

                            if (!empty($children)) {
                                foreach ($children as $child) {
                                    $q->orWhere('ID_BikeUser', array_get($child, 'ID_User'));
                                }
                            }
                        });
                        break;
                    case 'id_status':
                        $bike = $bike->where('ID_Status', $value);
                        break;
                    case 'class':
                        $bike = $bike->where('Class', $value);
                        break;
                }
            }
        }

        return $bike->orderBy('LastStatusChanged', 'desc')->paginate(25);
    }

    /**
     * Fetch a single bike by ID
     *
     * @param $bikeId
     *
     * @return Bike
     */
    public function fetchById($bikeId)
    {
        return Bike::with(['history', 'photos'])->where('ID_Bike', (int)$bikeId)->firstOrFail();
    }

    /**
     * @param array $payload
     *
     * @return Bike
     */
    public function create(array $payload)
    {
        //get the expected identifier for the bike
        $max = array_get(Bike::select(DB::raw('max(ID_Bike) as id'))->first()->toArray(), 'id', 1) + 1;

        $bike = new Bike();
        $bike->fill($payload);

        $bike->generateBikeLabel($max);

        $bike->save();

        return $bike->fresh();
    }

    /**
     * Update a bike's details, creating and updating history items
     *
     * @param       $bikeId
     * @param array $payload
     *
     * @return Bike
     */
    public function update($bikeId, array $payload)
    {
        $bike = $this->fetchById($bikeId);

        //retrieve the most recent history item
        /** @var BikeHistory $currentBikeHistory */
        $currentBikeHistory = BikeHistory::where('ID_Bike', $bikeId)->orderBy('CreateDateTime', 'desc')->first();

        $newStatus  = array_get($payload, 'ID_Status');
        $newDueDate = array_get($payload, 'DueDateTime');

        //determine if state has changed
        if ($currentBikeHistory->ID_Status != $newStatus) {

            //if the status change is not allowed, reject the request
            if (!$currentBikeHistory->isStatusChangeAllowed($newStatus)) {
                throw new InvalidStatusChangeException('Cannot change from status ' . Status::getName($currentBikeHistory->ID_Status) . ' to status ' . Status::getName($newStatus));
            }

            //if the due date is required but not provided, reject the request
            if ($currentBikeHistory->isDueDateRequired($newStatus) && empty(array_get($payload, 'DueDateTime'))) {
                throw new InvalidDueDateException('Due date time required to move to the status ' . Status::getName($newStatus));
            }

            //if the return date is required, set it
            if ($currentBikeHistory->isReturnDateRequired($newStatus)) {
                $this->bikeHistoryRepository->updateReturnDate($currentBikeHistory);
            }

            $bike->ID_Status         = $newStatus;
            $bike->LastStatusChanged = new Carbon();

            //update the previous bike history
            $currentBikeHistory->save();

            //create a new bike history
            $this->bikeHistoryRepository->create(
                $bikeId,
                $newStatus,
                array_get($payload, 'ID_BikeUser'),
                array_get($payload, 'ID_StaffUser')
            );
        } elseif ($currentBikeHistory->DueDateTime != $newDueDate) {
            //if the state has not changed, but the due date has, update the due date
            $this->bikeHistoryRepository->updateDueDate($currentBikeHistory, $newDueDate);
        }

        //cannot change serial number after creation
        unset($payload['SerialNumber']);
        unset($payload['ID_Status']);

        $bike->fill($payload);
        $bike->save();

        return $bike->fresh();
    }
}