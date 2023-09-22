<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'user_id',
        'start_date',
        'end_date',
        'total_asset',
        'total_unit',
        'status'
    ];
}
