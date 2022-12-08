<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

class BaseService {

    protected $model;

    protected function __construct($model)
    {
        $this->model = $model;
    }

    protected function create($payload)
    {
        return $this->model->create($payload);
    }
}