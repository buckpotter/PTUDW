<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class TicketDetail extends Model
{
    use HasFactory, Sortable;
    protected $primaryKey = 'IdCTBV';
    protected $keyType = 'string';

    protected $fillable = [
        'IdCTBV',
        'IdBanVe',
        'TenChoNgoi',
        'TinhTrangVe',
        'NgayBan',
        'GioBan',
        'created_at',
        'updated_at',
        // 'GiaVe',
    ];

    public $sortable = [
        'IdCTBV',
        'IdBanVe',
        'TenChoNgoi',
        'TinhTrangVe',
        'NgayBan',
        'GioBan',
    ];

    public $timestamps = true;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'IdBanVe', 'IdBanVe');
    }
}
