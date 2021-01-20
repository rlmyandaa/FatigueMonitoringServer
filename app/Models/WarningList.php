<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarningList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'attendance_id';
}
