<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'status',
        'log_date',
        'log_maker',
        'log_notes'
    ];
}
