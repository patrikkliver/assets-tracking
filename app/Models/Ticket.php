<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'user_id',
        'start_date',
        'end_date',
        'request_desc',
        'status',
        'action_date',
        'action_desc'
    ];
}
