<?php

namespace App\BLL;

use App\BLL\Repository\IEmployeesManager;
use App\BLL\Repository\IRotationManager;
use App\DAL\Repository\IEmployeeRepository;
use App\DAL\Repository\IRotationRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RotationManager implements IRotationManager
{
    const EMPLOYEES_PER_SHIFT = 2;

    const CONSECUTIVE_NONWORKING_DAYS = 2;

    /**
     * @var CarbonPeriod
     */
    private $_period = null;

    /**
     * @var IEmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var IRotationRepository
     */
    private $rotationRepository;

    public function __construct(IEmployeeRepository $employees, IRotationRepository $rotation)
    {
        $this->employeeRepository = $employees;
        $this->rotationRepository = $rotation;
    }

    public function setPeriod(Carbon $periodFrom, Carbon $periodTo)
    {
        $this->_period = $this->generateTimePeriod($periodFrom, $periodTo);
        return $this;
    }

    public function createRotation()
    {
        if (empty($this->_period)) {
            throw new \Exception('You have no period set for rota creation!');
        }

        $employees = $this->employeeRepository->getAllEmployees();
        $rotation = $this->getPreviousRotation();
        $rotation = $rotation ? $rotation->employees : collect([]);

        $rotationEntity = $this->rotationRepository->create($this->_period->getStartDate(), $this->_period->getEndDate());
        $candidates = [];

        foreach ($this->_period as $datePeriod) {
            if ($datePeriod->isWeekend()) {
                continue;
            }

            $employeesTemp = $employees->shuffle();
            $allShifts = [0, 1];

            foreach ($allShifts as $singleShift) {
                foreach ($employeesTemp as $key => $employeeEntity) {
                    $employeeShifts = $rotation->where('employee_id', $employeeEntity->id);

                    // employee in this period is not eligible work;
                    {
                        // Make space for other employees to fill their quota
                        if ($employeeShifts->count() >= 2) {
                            continue;
                        }

                        $employeeWorkTimeout = clone $datePeriod;
                        $employeeWorkTimeoutEnd = clone $datePeriod;
                        $employeeWorkTimeoutEnd->subDays(self::CONSECUTIVE_NONWORKING_DAYS);

                        $employeeWorkTimeoutPeriod = $this->generateTimePeriod($employeeWorkTimeout, $employeeWorkTimeoutEnd);
                        $employeeWorkTimeoutPeriod = array_map(function ($data) {
                            return $data->toDateString();
                        }, $employeeWorkTimeoutPeriod->toArray());

                        if ($employeeShifts->whereIn('date', $employeeWorkTimeoutPeriod)->count() > 0) {
                            continue;
                        }

                        $lastEmployeeRota = $employeeShifts->where('shift', $singleShift)->last();
                        if (!empty($lastEmployeeRota) && $lastEmployeeRota->shift === $singleShift) {
                            continue;
                        }
                    }

                    $rotationEmployee = [
                        'rotation_id' => $rotationEntity->id,
                        'employee_id' => $employeeEntity->id,
                        'date' => $datePeriod->toDateString(),
                        'shift' => (int)$singleShift,
                    ];

                    // Update main anchoring array to keep consistency with our checks
                    // after self::CONSECUTIVE_NONWORKING_DAYS days have passed into our new period
                    $rotation->push((object)$rotationEmployee);
                    // Update insert array to keep track of our new entries without looping them once again
                    // and inserting them all at once for efficiency
                    $candidates[$datePeriod->toDateString()][] = $rotationEmployee;

                    $employeesTemp->forget($key);

                    // wrap up for the day if shifts are filled
                    break;
                }
            }
        }
        $this->rotationRepository->addEmployeeBulk(array_merge(...array_values($candidates)));

        return $rotationEntity;
    }

    private function generateTimePeriod(Carbon $periodFrom, Carbon $periodTo)
    {
        $periodFrom = $periodFrom->startOfWeek();
        $periodTo = $periodTo->endOfWeek();

        return CarbonPeriod::between($periodFrom, $periodTo);
    }

    private function getPreviousRotation()
    {
        $startDate = $this->_period->getStartDate()->subWeeks(2);
        $endDate = $this->_period->getEndDate()->subWeeks(2);

        return $this->rotationRepository->get($startDate, $endDate);
    }
}
