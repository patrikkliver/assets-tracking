<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'asset_id',
        'unit_id'
    ];
}
