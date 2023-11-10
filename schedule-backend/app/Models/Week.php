<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Week extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'start_date', 'end_date', 'week'
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'week_id');
    }
}