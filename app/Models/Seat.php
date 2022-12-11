<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    protected $table = 'seats';
    protected $primaryKey = ['IdChuyen', 'IdXe', 'TenChoNgoi'];
    public $incrementing = false;
    protected $fillable = [
        'IdChuyen',
        'IdXe',
        'TenChoNgoi',
        // 'TrangThai',
    ];
}
