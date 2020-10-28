<?php

namespace App\BLL;

use App\BLL\Repository\IEmployeesManager;
use App\DAL\Repository\IEmployeeRepository;

class EmployeesManager implements IEmployeesManager
{
    /**
     * @var IEmployeeRepository
     */
    private $employees;

    public function __construct(IEmployeeRepository $employeeRepository)
    {
        $this->employees = $employeeRepository;
    }

    public function getAllEmployees()
    {
        return $this->employees->getAllEmployees();
    }
}
