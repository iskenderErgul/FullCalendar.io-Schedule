<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hour extends Model
{
    use HasFactory;

    protected $table = 'Hours';
    protected $primaryKey = 'hour_id';
    public $timestamps = false;

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class, 'day_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'hour_id');
    }
}
