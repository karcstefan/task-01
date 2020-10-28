<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property Collection employees
 */
class Rotation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'period_start', 'period_end',
    ];

    public function pivot()
    {
        return $this->hasMany(RotationEmployee::class);
    }
}
