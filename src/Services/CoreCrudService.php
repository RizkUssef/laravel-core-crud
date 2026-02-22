<?php

namespace Rizkussef\LaravelCoreCrud\Services;
use Illuminate\Support\Str;
class CoreCrudService
{
    protected $model;
    public function __construct()
    {
        if (!isset($this->model)) {
            $this->model = $this->resolveModel();
        }
    }
    public function resolveModel()
    {
        $serviceName = (new \ReflectionClass($this))->getShortName(); // e.g. UserService
        $modelName = Str::replaceLast('Service', '', $serviceName); // → Post
        $modelClass = "App\\Models\\{$modelName}";
        if (!class_exists($modelClass)) {
            throw new \Exception("Model {$modelClass} does not exist.");
        }

        return new $modelClass;
    }
    /**
     * Guess Resource class based on current service name
     */
    protected function resolveResource(): string
    {
        $serviceName = (new ReflectionClass($this))->getShortName(); // e.g. UserService
        $resourceName = Str::replaceLast('Service', 'Resource', $serviceName); // → UserResource
        $resourceClass = "App\\Http\\Resources\\{$resourceName}";

        if (!class_exists($resourceClass)) {
            throw new \Exception("Resource {$resourceClass} does not exist.");
        }
        return $resourceClass;
    }
    /**
     * Apply resource to data
     */
    protected function applyResource($data, bool $isCollection = false): mixed
    {
        $resourceClass = $this->resolveResource();

        if ($isCollection) {
            return $resourceClass::collection($data);
        }

        return new $resourceClass($data);
    }
    public function index()
    {
        $data = $this->model->all();
        return $this->applyResource($data, true);
    }
    public function getPaginated($perPage = 15)
    {
        $data = $this->model->paginate($perPage);
        return $this->applyResource($data, true);
    }
    public function store($data)
    {
        $data = $this->model->create($data);
        return $this->applyResource($data);
    }
    public function show($id)
    {
        $data = $this->model->findOrFail($id);
        return $this->applyResource($data);
    }
    public function update($id, $data)
    {
        $record = $this->model->findOrFail($id);
        return $record->update($data);
    }
    public function destroy($id)
    {
        $record = $this->model->findOrFail($id);
        return $record->delete();
    }
}