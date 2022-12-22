<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $primaryKey = 'IdRate';
    protected $keyType = 'string';

    protected $fillable = [
        'IdRate',
        'IdUser',
        'IdNX',
        // 'DanGia',
        'BinhLuan',
        // 'NgayDanhGia',
    ];

    public $timestamps = true;

    public function busCompany()
    {
        return $this->belongsTo(BusCompany::class, 'IdNX', 'IdNX');
    }

    public function normalUser()
    {
        return $this->belongsTo(NormalUser::class, 'IdUser', 'IdUser');
    }
}
