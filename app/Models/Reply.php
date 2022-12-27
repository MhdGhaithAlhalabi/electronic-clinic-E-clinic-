<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    public function doctor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->belongsTo(Doctor::class);
    }
    public function question(){
        return $this->belongsTo(Question::class);
    }
}
