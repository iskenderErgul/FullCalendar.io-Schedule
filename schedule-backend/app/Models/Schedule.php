<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';
    public $timestamps = true;

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class, 'day_id');
    }
}
