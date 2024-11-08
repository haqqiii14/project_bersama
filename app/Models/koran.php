<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class koran extends Model
{
    use HasFactory;

    public function koran()
    {
        return $this->belongsTo(koran::class);
    }
}
