<?php

namespace Rizkussef\LaravelCoreCrud\Http\Controllers;

use Rizkussef\LaravelCoreCrud\Services\CoreCrudService;
use Rizkussef\LaravelCoreCrud\Traits\ApiResponse;
use ReflectionClass;
use Illuminate\Support\Str;

class CoreCrudController
{
    use ApiResponse;
    public function __construct(public CoreCrudService $coreCrudService){}
    public function index()
    {
        return $this->success($this->coreCrudService->index(), 'Data retrieved successfully', 200);
    }
    public function getPaginated()
    {
        return $this->success($this->coreCrudService->getPaginated(config('core-crud.paginate', 15)), 'Data retrieved successfully', 200);
    }
    public function store($data)
    {
        return $this->success($this->coreCrudService->store($data), 'Data created successfully', 201);
    }
    public function show($id)
    {
        return $this->success($this->coreCrudService->show($id), 'Data retrieved successfully', 200);
    }
    public function update($id, $data)
    {
        return $this->success($this->coreCrudService->update($id, $data), 'Data updated successfully', 200);
    }
    public function destroy($id)
    {
        return $this->success($this->coreCrudService->destroy($id), 'Data deleted successfully', 200);
    }
}