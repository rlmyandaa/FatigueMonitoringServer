<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    public function report(){
        return $this->hasOne(Report::class, "attendance_id");
    }
}
