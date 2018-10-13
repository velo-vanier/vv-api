<?php

namespace App\Http\Controllers;

use App\Repositories\StatusRepository;

class StatusController extends Controller
{
    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * StatusController constructor.
     *
     * @param StatusRepository $repository
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * List all statuses in the system
     *
     * @return array
     */
    public function index()
    {
        return $this->statusRepository->fetchAll();
    }
}