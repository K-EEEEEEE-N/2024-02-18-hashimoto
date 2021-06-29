<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestController extends Controller
{
    public function startRest()
    {
        $id = Auth::id();

        $dt = new Carbon();
        $date = $dt->toDateString();

        $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();

        $attendance_id = $attendance->id;

        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toTimeString();

        Rest::create([
            'attendance_id' => $attendance_id,
            'start_time' => $time,
        ]);
        return redirect('/')->with('result', '
        休憩開始しました');
    }

    public function endRest()
    {
        $id = Auth::id();

        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toTimeString();

        $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();

        $rest = $attendance->rests->whereNull("end_time")->first();

        Rest::where('id', $rest->id)->update(['end_time' => $time]);
        return redirect('/')->with('result', '
        休憩終了しました');
    }
}