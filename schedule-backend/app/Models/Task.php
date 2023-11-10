<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'active', 'week_id', 'title', 'description', 'hours'
    ];

    protected $casts = [
        'hours' => 'json',
    ];

    public function week()
    {
        return $this->belongsTo(Week::class, 'week_id');
    }

}
