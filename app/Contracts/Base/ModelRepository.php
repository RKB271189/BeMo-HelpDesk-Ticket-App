<?php

namespace App\Contracts\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ModelRepository implements ModelInterface
{
    public function __construct(private Model $model) {}
    public function getData(int $limit = 0): Collection
    {
        if ($limit === 0) {
            return $this->model->get();
        } else {
            return $this->model->limit($limit)->get();
        }
    }
    public function getDataById($id): Model
    {
        return $this->model->find($id);
    }
    public function createData(array $params): Model
    {
        return $this->model->create($params);
    }
    public function updateData(array $params, $id): Model
    {
        $obtModel = $this->model->findOrFail($id);
        return tap($obtModel)->update($params);
    }
    public function deleteData($id): int
    {
        $obtModel = $this->getDataById($id);
        return $obtModel->delete();
    }
}
