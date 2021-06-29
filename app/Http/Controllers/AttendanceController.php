<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function getIndex()
    {
        $id = Auth::id();

        $dt = new Carbon();
        $date = $dt->toDateString();

        $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();

        if (empty($attendance)) {
            return view('index');
        }
        $rest = $attendance->rests->whereNull("end_time")->first();

        if ($attendance->end_time) {
            return view('index')->with([
                "is_attendance_start" => true,
                "is_attendance_end" => true,
            ]);
        }
        if ($attendance->start_time) {
            if (isset($rest)) {
                return view('index')->with([
                    "is_rest" => true,
                    "is_attendance_start" => true,
                ]);
            } else {
                return view('index')->with([
                    "is_rest" => false,
                    "is_attendance_start" => true,
                ]);
            }
        }
    }

    public function startAttendance()
    {
        $id = Auth::id();

        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toTimeString();

        Attendance::create([
            'user_id' => $id,
            'date' => $date,
            'start_time' => $time,
        ]);
        return redirect('/')->with('result', '
        勤務開始しました');
    }

    public function endAttendance()
    {
        $id = Auth::id();

        $dt = new Carbon();
        $time = $dt->toTimeString();

        Attendance::where('user_id', $id)->update(['end_time' => $time]);
        return redirect('/')->with('result', '
        勤務終了しました');
    }

    public function getAttendance(Request $request)
    {
        $num = (int)$request->num;
        $dt = new Carbon();
        if ($num == 0) {
            $date = $dt;
        } elseif ($num > 0) {
            $date = $dt->addDays($num);
        } else {
            $date = $dt->subDays(-$num);
        }
        $fixed_date = $date->toDateString();

        $attendances = Attendance::where('date', $fixed_date)->paginate(5);

        foreach ($attendances as $index => $attendance) {
            $rests = $attendance->rests;
            $sum = 0;
            foreach ($rests as $rest) {
                $start_time = $rest->start_time;
                $start_dt = new Carbon($start_time);
                $end_time = $rest->end_time;
                $end_dt = new Carbon($end_time);
                $diff_seconds = $start_dt->diffInSeconds($end_dt);
                $sum = $sum + $diff_seconds;
            }
            $start_at = new Carbon($attendance->start_time);
            $end_at = new Carbon($attendance->end_time);

            $diff_start_end = $start_at->diffInSeconds($end_at);
            $diff_work = $diff_start_end - $sum;


            $res_hours = floor($sum / 3600);
            $res_minutes = floor(($sum / 60) % 60);
            $res_seconds = $sum % 60;

            $work_hours = floor($diff_work / 3600);
            $work_minutes = floor(($diff_work / 60) % 60);
            $work_seconds = $diff_work % 60;

            $time_dt = Carbon::createFromTime($res_hours, $res_minutes, $res_seconds);

            $time_work = Carbon::createFromTime($work_hours, $work_minutes, $work_seconds);

            $attendances[$index]->rest_sum = $time_dt->toTimeString();
            $attendances[$index]->work_time = $time_work->toTimeString();
        }

        return view('attendance', compact("attendances", "num", "fixed_date"));
    }
}