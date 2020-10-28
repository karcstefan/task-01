<?php

namespace App\DAL\Repository;

use App\Models\Rotation;

interface IRotationRepository
{
    /**
     * @param $startDate
     * @param $endDate
     * @return Rotation
     */
    public function get($startDate, $endDate);

    /**
     * @param $startDate
     * @param $endDate
     * @return Rotation
     */
    public function create($startDate, $endDate);

    /**
     * @param array $employees
     * @return bool
     */
    public function addEmployeeBulk(array $employees);

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
    public function getLastPeriod();

    /**
     * @param int $id
     * @return Rotation
     */
    public function find($id);
}
