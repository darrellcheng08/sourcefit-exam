<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;

use Image;
use DB;
use Storage;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {
            $attendance = Attendance::query();

            $data = $attendance->paginate($request->itemsPerPage);

            return response()->json($data, 200);
        
        } catch (\Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ];
            Log::error($error);

            return response()->json([
                "status" => "error",
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function timeIn(Request $request)
    {
        try 
        {
            if ($request->user_id) 
            {
                DB::beginTransaction();
                $user = User::find($request->user_id);

                $model = new Attendance();
                $model->user_id = $user->id ?? null;
                $model->user_name = $user->name ?? null;
                $model->time_in = date('Y-m-d H:i:s');
                $model->save();

                $user->active_attendance_id = $model->id;
                $user->save();

                DB::commit();

                // 200: OK. The standard success code and default option.
                return response()->json([
                    "status" => "success",
                    'message' => "User successfully Time In.",
                    'data' => $model
                ], 200);

            } else {
                return response()->json([
                    "status" => "error",
                    'message' => "Invalid request.",
                    'data' => null
                ], 200);
            }

        } catch (\Exception $e) {
            DB::rollback();
            $error = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ];
            Log::error($error);

            return response()->json([
                "status" => "error",
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function timeOut(Request $request)
    {
        try 
        {
            if ($request->user_id) 
            {
                DB::beginTransaction();

                $user = User::find($request->user_id);
                $attendance = Attendance::find($user->active_attendance_id); // find the user active or current attendance id for updating of timeout

                $date_time_now = date('Y-m-d H:i:s');
                $date_time_start = date('Y-m-d 8:00:00'); // work start at 8am
                $total_hrs_per_day = 8; // total hours per day
                $break_hours = 1; // total hours break
                $total_hrs_worked = $this->computeTotalHours($attendance->time_in, $date_time_now) - $break_hours; // remove break from total hours worked
                $hrs_late = $this->computeTotalHours($date_time_start, $attendance->time_in);
                $under_time = $total_hrs_per_day > $total_hrs_worked ? round($total_hrs_per_day - $total_hrs_worked, 2) : 0;
                $hrs_overtime = $total_hrs_worked > $total_hrs_per_day ? round($total_hrs_worked - $total_hrs_per_day, 2) : 0;
    
                $attendance->time_out = $date_time_now;
                $attendance->hrs_worked = $total_hrs_worked;
                $attendance->hrs_late = $hrs_late;
                $attendance->hrs_undertime = $under_time;
                $attendance->hrs_overtime = $hrs_overtime;
                $attendance->save();

                // once the user is successfully timeout remove the active attendance id or mark as null
                $user->active_attendance_id = null;
                $user->save();

                DB::commit();
    
                return response()->json([
                    "status" => "success",
                    'message' => "User successfully Time Out.",
                    'data' => $attendance
                ], 200);

            } else {
                return response()->json([
                    "status" => "error",
                    'message' => "Invalid request.",
                    'data' => null
                ], 200);
            }

        } catch (\Exception $e) {
            DB::rollback();
            $error = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ];
            Log::error($error);

            return response()->json([
                "status" => "error",
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function computeTotalHours($from, $to) 
    {
        // multiply the diffrence time to 3600 to change to second and then add with time in
        $emp_in = strtotime($from);
        $emp_out = strtotime($to);

        $result_in_out = $emp_out - $emp_in;
        $total_hrs_worked = abs($result_in_out / 3600);

        return round($total_hrs_worked, 2);
    }
}
