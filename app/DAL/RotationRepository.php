<?php

namespace App\DAL;

use App\DAL\Repository\Collection;
use App\DAL\Repository\IEmployeeRepository;
use App\DAL\Repository\IRotationRepository;
use App\Models\Employee;
use App\Models\Rotation;
use App\Models\RotationEmployee;

class RotationRepository implements IRotationRepository
{
    /**
     * @var Rotation
     */
    private $rotationModel;

    /**
     * @var RotationEmployee
     */
    private $rotationEmployeeModel;

    public function __construct(Rotation $rotation, RotationEmployee $rotationEmployee)
    {
        $this->rotationModel = $rotation;
        $this->rotationEmployeeModel = $rotationEmployee;
    }

    public function get($startDate, $endDate)
    {
        return $this->rotationModel->with('pivot')->where('period_start', $startDate)->where('period_end', $endDate)->first();
    }

    public function create($startDate, $endDate)
    {
        return $this->rotationModel->create([
            'period_start' => $startDate,
            'period_end' => $endDate,
        ]);
    }

    public function addEmployeeBulk(array $employees)
    {
        return $this->rotationEmployeeModel->insert($employees);
    }

    public function all()
    {
        return $this->rotationModel->with('pivot', 'pivot.employee')->orderByDesc('period_start')->get();
    }

    public function delete($id)
    {
        return $this->rotationModel->find($id)->delete();
    }

    public function getLastPeriod()
    {
        return $this->rotationModel->with('pivot')->orderByDesc('period_start')->first();
    }

    public function find($id)
    {
        return $this->rotationModel->find($id);
    }
}
