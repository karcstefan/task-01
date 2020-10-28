<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RotationEmployee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rotation_id', 'employee_id', 'shift'
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function rotation()
    {
        return $this->hasOne(Rotation::class, 'id', 'rotation_id');
    }
}
