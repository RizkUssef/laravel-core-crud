<?php

namespace Rizkussef\LaravelCoreCrud\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Rizkussef\LaravelCoreCrud\Services\CoreCrudService;
use Rizkussef\LaravelCoreCrud\Traits\ApiResponse;
use Illuminate\Support\Str;

class CoreCrudController
{
    use ApiResponse;
    protected string $formRequest;
    protected string $updateRequest;
    protected CoreCrudService $service;
    public function __construct(CoreCrudService $service)
    {
        if (!isset($this->formRequest))
            $this->formRequest = $this->resolveFormRequest();

        if (!isset($this->updateRequest))
            $this->updateRequest = $this->resolveUpdateRequest();
        $this->service = $service;
    }
    protected function resolveEntityName(): string
    {
        $controllerName = (new \ReflectionClass($this))->getShortName();
        return Str::replaceLast('Controller', '', $controllerName);
    }

    protected function resolveFormRequest(): string
    {
        $formRequest = $this->formRequest ??
            "App\\Http\\Requests\\{$this->resolveEntityName()}Request";

        if (!class_exists($formRequest))
            throw new \Exception("{$formRequest} does not exist.");

        return $formRequest;
    }

    protected function resolveUpdateRequest(): string
    {
        $updateRequest = $this->updateRequest ??
            "App\\Http\\Requests\\{$this->resolveEntityName()}UpdateRequest";

        if (!class_exists($updateRequest))
            return $this->formRequest;

        return $updateRequest;
    }
    public function index()
    {
        return $this->success($this->service->index(), 'Data retrieved successfully', 200);
    }
    public function getPaginated()
    {
        return $this->success($this->service->getPaginated(config('core-crud.paginate', 15)), 'Data retrieved successfully', 200);
    }
    public function store(Request $request)
    {
        $formRequest = app($this->formRequest);
        $formRequest->validateResolved();
        $data = $formRequest->validated();
        return $this->success($this->service->store($data), 'Data created successfully', 201);
    }
    public function show($id)
    {
        return $this->success($this->service->show($id), 'Data retrieved successfully', 200);
    }
    public function update(Request $request, $id)
    {
        $updateRequest = app($this->updateRequest);
        $updateRequest->validateResolved();
        $data = $updateRequest->validated();
        return $this->success($this->service->update($id, $data), 'Data updated successfully', 200);
    }
    public function destroy($id)
    {
        return $this->success($this->service->destroy($id), 'Data deleted successfully', 200);
    }
}
