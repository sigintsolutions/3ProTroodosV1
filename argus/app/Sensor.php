<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sensor extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
    ];

    protected $fillable = [
        'hub_id',
        'sensor_id',
		'type',
		'brand',
		'measure_unit',
		'sensor_inform',
        'created_at',
    ];
}
