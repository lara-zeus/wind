<?php

namespace LaraZeus\Wind;

trait Configuration
{
    protected bool $hasDepartmentResource = true;

    protected string $departmentModel = \LaraZeus\Wind\Models\Department::class;

    protected string $letterModel = \LaraZeus\Wind\Models\Letter::class;

    protected string $uploadDisk = 'public';

    protected string $uploadDirectory = 'logos';

    protected string $navigationGroupLabel = 'Wind';

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
