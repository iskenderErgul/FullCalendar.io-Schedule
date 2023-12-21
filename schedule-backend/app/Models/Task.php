<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'active', 'week_id', 'title', 'description',
        'start_time' , 'end_time'
    ];


    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class, 'week_id');

    }
}
