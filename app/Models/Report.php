<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $primaryKey = 'attendance_id';
    public function person(){
        return $this->belongsTo(Person::class, "user_id");
    }
    public function attendance(){
        return $this->belongsTo(Attendance::class, "attendance_id");
    }
}
