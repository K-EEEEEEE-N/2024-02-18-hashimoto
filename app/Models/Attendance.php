<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','date','start_time','end_time'];

    public function rests()
    {
        return $this->hasMany('App\Models\Rest');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }
}