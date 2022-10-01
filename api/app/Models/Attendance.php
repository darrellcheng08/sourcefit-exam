<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = "attendance";
    protected $fillable = ['user_id', 'user_name', 'time_in', 'time_out', 'hrs_worked', 'hrs_late', 'hrs_undertime', 'hrs_overtime'];
}
