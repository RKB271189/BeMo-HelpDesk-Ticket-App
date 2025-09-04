<?php

namespace App\Contracts\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ModelInterface
{
    public function getData(int $limit = 0): Collection;

    public function getDataById($id): Model;

    public function createData(array $params): Model;

    public function updateData(array $params, $id): Model;

    public function deleteData($id): int;
}
