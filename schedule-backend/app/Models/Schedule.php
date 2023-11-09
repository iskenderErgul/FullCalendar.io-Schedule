<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['day_id', 'hour_id', 'task_id'];

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class, 'day_id');
    }

    public function hour(): BelongsTo
    {
        return $this->belongsTo(Hour::class, 'hour_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
