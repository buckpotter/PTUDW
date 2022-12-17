<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class NormalUser extends Model
{
    use HasFactory, Sortable;
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

    public $sortable = [
        'IdUser',
        'HoTen',
        'email',
        'sdt',
    ];

    public function rates()
    {
        return $this->hasMany(Rate::class, 'IdUser', 'IdUser');
    }
}
