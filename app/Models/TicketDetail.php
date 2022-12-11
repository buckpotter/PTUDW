<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'IdCTBV';
    protected $keyType = 'string';

    protected $fillable = [
        'IdCTBV',
        'IdBanVe',
        'TenChoNgoi',
        'TinhTrangVe',
        'NgayBan',
        'GioBan',
        // 'GiaVe',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'IdBanVe', 'IdBanVe');
    }
}
