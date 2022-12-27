<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public function patient(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->belongsTo(Patient::class);
    }
}
