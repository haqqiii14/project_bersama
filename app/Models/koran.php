<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class koran extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'edisi',
        'pages',
        'published',
        'description',
        'image',
        'file',
        'status',
        'price',
        'views',
        'read'
    ];

    public function koran()
    {
        return $this->belongsTo(koran::class);
    }
}
