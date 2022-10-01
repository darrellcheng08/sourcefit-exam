<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $appends = ['total_hrs_worked'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function getTotalHrsWorkedAttribute() // notice that the attribute name is in CamelCase.
    {
        // check if this user has an active attendance
        if ($this->active_attendance_id) {
            $attendance = Attendance::find($this->active_attendance_id);
            return $this->computeTotalHours($attendance->time_in);
        }
    }

    public function computeTotalHours($from) 
    {
        $date_time_now = date('Y-m-d H:i:s');
        // multiply the diffrence time to 3600 to change to second and then add with time in
        $emp_in = strtotime($from);
        $emp_out = strtotime($date_time_now);

        $result_in_out = $emp_out - $emp_in;
        $total_hrs_worked = abs($result_in_out / 3600);

        return round($total_hrs_worked, 2);
    }
}
