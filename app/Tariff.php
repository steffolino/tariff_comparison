<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    //
    protected $fillable = ['name', 'annual_costs', 'monthly', 'per_kwh', 'flatrate_consumption'];
}
