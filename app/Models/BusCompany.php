<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusCompany extends Model
{
    use HasFactory;

    protected $primaryKey = 'IdNX';
    protected $keyType = 'string';

    protected $fillable = [
        'IdNX',
        'Ten_NX',
        'sdt',
        'email',
        'DichVu',
        // 'IdRate',
    ];

    public function rates()
    {
        return $this->hasMany(Rate::class, 'IdNX', 'IdNX');
    }

    public function buses()
    {
        return $this->hasMany(Bus::class, 'IdNX', 'IdNX');
    }
}
