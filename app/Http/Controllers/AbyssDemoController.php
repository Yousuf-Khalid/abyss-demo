<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\AbyssDemoService;

class AbyssDemoController extends Controller
{

    /**
     * Set Service Instance
     */
    private $service;

    /**
     * Class Constructor
     * 
     * @param AbyssDemoService $service
     */
    public function __construct(AbyssDemoService $service)
    {
        $this->service = $service;
    }

    /**
     * Create new record
     * 
     * @param Request $request
     * @return object
     */
    public function create(Request $request)
    {
        return $this->service->create($request);
    }

    /**
     * Fetch paginated records
     * 
     * @param Request $request
     * @return object
     */
    public function all(Request $request)
    {
        return $this->service->all($request);
    }

    /**
     * Fetch single record w.r.t id
     * 
     * @param $id
     * @return object
     */
    public function getById($id)
    {
        return $this->service->getById($id);
    }
}
