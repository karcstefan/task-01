<?php

namespace App\Providers;

use App\DAL\EmployeeRepository;
use App\DAL\Repository\IEmployeeRepository;
use App\DAL\Repository\IRotationRepository;
use App\DAL\RotationRepository;
use Illuminate\Support\ServiceProvider;

class DALServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IEmployeeRepository::class, EmployeeRepository::class);
        $this->app->bind(IRotationRepository::class, RotationRepository::class);
    }
}
