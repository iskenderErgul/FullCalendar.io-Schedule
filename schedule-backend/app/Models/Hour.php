<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hour extends Model
{
    protected $primaryKey = 'hour_id';
    public $timestamps = true;

    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_id');
    }

    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id');
    }
}
