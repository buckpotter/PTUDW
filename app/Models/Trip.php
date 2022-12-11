<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $primaryKey = 'IdChuyen';
    protected $keyType = 'string';

    protected $fillable = [
        'IdChuyen',
        'IdTuyen',
        'NgayDi',
        'GioDi',
        'NgayDen',
        'GioDen',
        'IdXe',
        'GiaVe',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'IdXe', 'IdXe');
    }

    public function busRoute()
    {
        return $this->belongsTo(BusRoute::class, 'IdTuyen', 'IdTuyen');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'IdChuyen', 'IdChuyen');
    }
}
