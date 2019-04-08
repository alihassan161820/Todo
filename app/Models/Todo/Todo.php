<?php

namespace App\Models\Todo;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'description',
        'status',
        'created_at',
    ];
}
