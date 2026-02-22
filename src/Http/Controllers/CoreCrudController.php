<?php

namespace Rizkussef\LaravelCoreCrud\Http\Controllers;

use Rizkussef\LaravelCoreCrud\Services\CoreCrudService;
use Rizkussef\LaravelCoreCrud\Traits\ApiResponse;

class CoreCrudController
{
    use ApiResponse;
    protected CoreCrudService $service;
    public function __construct(CoreCrudService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return $this->success($this->service->index(), 'Data retrieved successfully', 200);
    }
    public function getPaginated()
    {
        return $this->success($this->service->getPaginated(config('core-crud.paginate', 15)), 'Data retrieved successfully', 200);
    }
    public function store($data)
    {
        return $this->success($this->service->store($data), 'Data created successfully', 201);
    }
    public function show($id)
    {
        return $this->success($this->service->show($id), 'Data retrieved successfully', 200);
    }
    public function update($id, $data)
    {
        return $this->success($this->service->update($id, $data), 'Data updated successfully', 200);
    }
    public function destroy($id)
    {
        return $this->success($this->service->destroy($id), 'Data deleted successfully', 200);
    }
}
