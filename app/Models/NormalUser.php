<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormalUser extends Model
{
    use HasFactory;
    protected $primaryKey = 'IdUser';
    protected $keyType = 'string';

    protected $fillable = [
        'IdUser',
        'HoTen',
        'email',
        'password',
        'sdt',
        'image',
        'token'
    ];

    public function rates()
    {
        return $this->hasMany(Rate::class, 'IdUser', 'IdUser');
    }
}
