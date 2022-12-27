<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public function region(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Region::class);
    }
    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->hasMany(Doctor::class);
    }
}
