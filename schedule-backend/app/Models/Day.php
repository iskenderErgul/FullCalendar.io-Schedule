<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Day extends Model
{
    use HasFactory;

    protected $table = 'Days';
    protected $primaryKey = 'day_id';
    public $timestamps = false;

    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class, 'day_id');
    }
}
