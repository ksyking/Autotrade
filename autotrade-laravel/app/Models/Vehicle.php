<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    // Assuming your table is "vehicles" (matches your migration filename)
    protected $table = 'vehicles';

    // Make it easy to insert demo data without mass-assignment errors
    protected $guarded = [];

    // If you have timestamps in the table, leave this true; otherwise set to false.
    public $timestamps = true;
}