<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;
    protected $table = 'stops';
    protected $fillable = [
        'id',
        'Ten',
        'DiaChi',
        'DiaDiemDi',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'DiaDiemDi', 'DiaDiem');
    }
}
