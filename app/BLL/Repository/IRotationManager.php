<?php

namespace App\BLL\Repository;

use App\Models\Rotation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

interface IRotationManager
{
    /**
     * @param Carbon $periodFrom
     * @param Carbon $periodTo
     * @return CarbonPeriod
     */
    public function setPeriod(Carbon $periodFrom, Carbon $periodTo);

    /**
     * @return Rotation
     */
    public function createRotation();
}
