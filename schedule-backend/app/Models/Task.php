<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;
    protected $table = 'Tasks';
    protected $primaryKey = 'task_id';
    public $timestamps = false;

    public function hour(): BelongsTo
    {
        return $this->belongsTo(Hour::class, 'hour_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'task_id');
    }

}
