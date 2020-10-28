<?php

namespace App\BLL\Repository;

use App\Models\Rotation;

interface IRotationBLL
{
    /**
     * @return Collection
     */
    public function all();

    /**
     * @param $id
     * @return bool
     */
    public function delete($id);

    /**
     * @return Rotation
     */
    public function create();
}
