<?php

namespace App\Http\Controllers;

use App\BLL\RotationManager;
use Carbon\Carbon;

class ExampleController extends Controller
{
    /**
     * @var RotationManager
     */
    private $rotationManager;

    /**
     * Create a new controller instance.
     *
     * @param RotationManager $rotationManager
     */
    public function __construct(RotationManager $rotationManager)
    {
        $this->rotationManager = $rotationManager;
    }

    public function test()
    {
        $periodFrom = Carbon::parse('2020-10-19');
        $periodTo = Carbon::parse('2020-11-01');

        $this->rotationManager->setPeriod($periodFrom, $periodTo);
        $output = $this->rotationManager->createRotation();
        dd($output);
    }
}
