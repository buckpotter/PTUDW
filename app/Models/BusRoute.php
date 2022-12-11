<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusRoute extends Model
{
    use HasFactory;
    protected $primaryKey = 'IdTuyen';
    protected $keyType = 'string';

    protected $fillable = [
        'IdTuyen',
        'TenTuyen',
        'DiaDiemDi',
        'DiaDiemDen',
    ];

    // public function bus()
    // {
    //     return $this->hasMany(Bus::class, 'IdTuyen', 'IdTuyen');
    // }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'IdTuyen', 'IdTuyen');
    }

    public function departure()
    {
        return $this->belongsTo(Location::class, 'DiaDiemDi', 'DiaDiem');
    }

    public function destination()
    {
        return $this->belongsTo(Location::class, 'DiaDiemDen', 'DiaDiem');
    }
}
