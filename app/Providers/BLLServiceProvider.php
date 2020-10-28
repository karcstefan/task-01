<?php

namespace App\Providers;

use App\BLL\EmployeesManager;
use App\BLL\Repository\IEmployeesManager;
use App\BLL\Repository\IRotationBLL;
use App\BLL\Repository\IRotationManager;
use App\BLL\RotationBLL;
use App\BLL\RotationManager;
use Illuminate\Support\ServiceProvider;

class BLLServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IRotationBLL::class, RotationBLL::class);
        $this->app->bind(IRotationManager::class, RotationManager::class);
        $this->app->bind(IEmployeesManager::class, EmployeesManager::class);
    }
}
