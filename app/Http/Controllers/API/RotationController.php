<?php

namespace App\Http\Controllers\API;

use App\BLL\Repository\IRotationBLL;
use App\Http\Controllers\Controller;

class RotationController extends Controller
{
    /**
     * @var IRotationBLL
     */
    private $rotationBLL;

    /**
     * Create a new controller instance.
     *
     * @param IRotationBLL $rotation
     */
    public function __construct(IRotationBLL $rotation)
    {
        $this->rotationBLL = $rotation;
    }

    public function index()
    {
        $rotations = $this->rotationBLL->all();

        return response()->json($rotations);
    }

    public function delete($id)
    {
        $success = $this->rotationBLL->delete($id);

        return response()->json($success);
    }

    public function create()
    {
        $rotation = $this->rotationBLL->create();
        return response()->json($rotation);
    }
}
