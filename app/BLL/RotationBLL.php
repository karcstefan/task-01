<?php

namespace App\BLL;

use App\BLL\Repository\IRotationBLL;
use App\DAL\Repository\IRotationRepository;
use App\Models\Rotation;
use Carbon\Carbon;

class RotationBLL implements IRotationBLL
{
    /**
     * @var IRotationRepository
     */
    private $rotation;

    /**
     * @var RotationManager
     */
    private $manager;

    public function __construct(IRotationRepository $rotation, RotationManager $rotationManager)
    {
        $this->rotation = $rotation;
        $this->manager = $rotationManager;
    }

    public function all()
    {
        return $this->rotation->all();
    }

    public function delete($id)
    {
        return $this->rotation->delete($id);
    }

    public function create()
    {
        $lastPeriod = $this->rotation->getLastPeriod();

        $startDate = $lastPeriod ? Carbon::parse($lastPeriod->period_end)->addDay() : Carbon::now();
        $endDate = clone $startDate;
        $endDate->addWeek();

        $this->manager->setPeriod($startDate, $endDate);
        $rotation = $this->manager->createRotation();


        $rotation = $this->rotation->find($rotation->id)->load('pivot', 'pivot.employee');
        return $rotation;
    }
}
