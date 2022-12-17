<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class BusCompany extends Model
{
    use HasFactory, Sortable;

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

    public $sortable = [
        'IdNX',
        'Ten_NX',
        'sdt',
        'email',
        'DichVu',
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
