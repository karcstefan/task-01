<?php

namespace App\DAL;

use App\DAL\Repository\IEmployeeRepository;
use App\Models\Employee;

class EmployeeRepository implements IEmployeeRepository
{
    /**
     * @var Employee
     */
    private $employeeModel;

    public function __construct(Employee $employee)
    {
        $this->employeeModel = $employee;
    }

    public function getAllEmployees()
    {
        return $this->employeeModel->all();
    }
}
