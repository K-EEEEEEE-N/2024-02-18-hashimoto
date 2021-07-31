@extends('layouts.app')

@section('main')
<div class="date-container">
    <a class="arrow" href="{!! '/attendance/' . ($num - 1) !!}">&lt;</a>
    <p class="date">{{ $fixed_date }}</p>
    <a class="arrow" href="{!! '/attendance/' . ($num + 1) !!}">&gt;</a>
</div>
<table>
    <tr>
        <th>名前</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
    </tr>
    @foreach ($adjustAttendances as $attendance)
    <tr>
        <td>{{ $attendance->users->name }}</td>
        <td>{{ $attendance->start_time }}</td>
        <td>{{ $attendance->end_time }}</td>
        <td>{{ $attendance->rest_sum }}</td>
        <td>{{ $attendance->work_time }}</td>
    </tr>
    @endforeach
</table>
{{ $adjustAttendances->links('pagination::default') }}

@endsection