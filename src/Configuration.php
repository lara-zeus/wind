<?php

namespace LaraZeus\Wind;

trait Configuration
{
    /**
     * set the default path for the contact form homepage.
     */
    protected string $windPrefix = 'wind';

    /**
     * the middleware you want to apply on the contact routes
     */
    protected array $windMiddleware = ['web'];

    /**
     * you can set a default department to receive all messages, if the user didn't chose one.
     */
    protected int $defaultDepartmentId = 1;

    /**
     * set the default status that all messages will have when received.
     */
    protected string $defaultStatus = 'NEW';

    protected bool $hasDepartmentResource = true;

    protected string $departmentModel = \LaraZeus\Wind\Models\Department::class;

    protected string $letterModel = \LaraZeus\Wind\Models\Letter::class;

    protected string $uploadDisk = 'public';

    protected string $uploadDirectory = 'logos';

    protected string $navigationGroupLabel = 'Wind';

    public function windPrefix(string $prefix): static
    {
        $this->windPrefix = $prefix;

        return $this;
    }

    public function getWindPrefix(): string
    {
        return $this->windPrefix;
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

    public function defaultDepartmentId(int $defaultDepartment): static
    {
        $this->defaultDepartmentId = $defaultDepartment;

        return $this;
    }

    public function getDefaultDepartmentId(): int
    {
        return $this->defaultDepartmentId;
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

    public function departmentModel(string $model): static
    {
        $this->departmentModel = $model;

        return $this;
    }

    public function getDepartmentModel(): string
    {
        return $this->departmentModel;
    }

    public function letterModel(string $model): static
    {
        $this->letterModel = $model;

        return $this;
    }

    public function getLetterModel(): string
    {
        return $this->letterModel;
    }

    public function uploadDisk(string $disk): static
    {
        $this->uploadDisk = $disk;

        return $this;
    }

    public function getUploadDisk(): string
    {
        return $this->uploadDisk;
    }

    public function uploadDirectory(string $dir): static
    {
        $this->uploadDirectory = $dir;

        return $this;
    }

    public function getUploadDirectory(): string
    {
        return $this->uploadDirectory;
    }

    public function navigationGroupLabel(string $lable): static
    {
        $this->navigationGroupLabel = $lable;

        return $this;
    }

    public function getNavigationGroupLabel(): string
    {
        return $this->navigationGroupLabel;
    }
}
