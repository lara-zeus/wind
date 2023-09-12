<?php

namespace LaraZeus\Wind;

use Closure;

trait Configuration
{
    /**
     * set the default path for the contact form homepage.
     */
    protected Closure | string $windPrefix = 'wind';

    /**
     * the middleware you want to apply on the contact routes
     */
    protected array $windMiddleware = ['web'];

    /**
     * you can set a default department to receive all messages, if the user didn't chose one.
     */
    protected Closure | int $defaultDepartmentId = 1;

    /**
     * set the default status that all messages will have when received.
     */
    protected string $defaultStatus = 'NEW';

    protected bool $hasDepartmentResource = true;

    /**
     * you can overwrite any model and use your own
     */
    protected array $windModels = [
        'Department' => \LaraZeus\Wind\Models\Department::class,
        'Letter' => \LaraZeus\Wind\Models\Letter::class,
    ];

    protected Closure | string $uploadDisk = 'public';

    protected Closure | string $uploadDirectory = 'logos';

    protected Closure | string $navigationGroupLabel = 'Wind';

    public function windPrefix(Closure | string $prefix): static
    {
        $this->windPrefix = $prefix;

        return $this;
    }

    public function getWindPrefix(): Closure | string
    {
        return $this->evaluate($this->windPrefix);
    }

    public function windMiddleware(array $middleware): static
    {
        $this->windMiddleware = $middleware;

        return $this;
    }

    public function getMiddleware(): array
    {
        return $this->windMiddleware;
    }

    public function defaultStatus(string $status): static
    {
        $this->defaultStatus = $status;

        return $this;
    }

    public function getDefaultStatus(): string
    {
        return $this->defaultStatus;
    }

    public function defaultDepartmentId(Closure | int $defaultDepartment): static
    {
        $this->defaultDepartmentId = $defaultDepartment;

        return $this;
    }

    public function getDefaultDepartmentId(): Closure | int
    {
        return $this->evaluate($this->defaultDepartmentId);
    }

    public function departmentResource(bool $condition = true): static
    {
        $this->hasDepartmentResource = $condition;

        return $this;
    }

    public function hasDepartmentResource(): bool
    {
        return $this->hasDepartmentResource;
    }

    public function uploadDisk(Closure | string $disk): static
    {
        $this->uploadDisk = $disk;

        return $this;
    }

    public function getUploadDisk(): Closure | string
    {
        return $this->evaluate($this->uploadDisk);
    }

    public function uploadDirectory(Closure | string $dir): static
    {
        $this->uploadDirectory = $dir;

        return $this;
    }

    public function getUploadDirectory(): Closure | string
    {
        return $this->evaluate($this->uploadDirectory);
    }

    public function navigationGroupLabel(Closure | string $lable): static
    {
        $this->navigationGroupLabel = $lable;

        return $this;
    }

    public function getNavigationGroupLabel(): Closure | string
    {
        return $this->evaluate($this->navigationGroupLabel);
    }

    public function windModels(array $models): static
    {
        $this->windModels = $models;

        return $this;
    }

    public function getWindModels(): array
    {
        return $this->windModels;
    }

    public static function getModel(string $model): string
    {
        return array_merge(
            (new static())->windModels,
            (new static())::get()->getWindModels()
        )[$model];
    }
}
