<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct()
    {
        $this->model = resolve($this->getModelClass());
    }

    abstract protected function getModelClass(): string;
}
