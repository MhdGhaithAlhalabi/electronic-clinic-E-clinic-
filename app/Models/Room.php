<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public function patient(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Patient::class);
    }
    public function doctor(){
        return $this->hasOne(Doctor::class);
    }
    public function consultation(){
        return $this->hasOne(Consultation::class);
    }
}
