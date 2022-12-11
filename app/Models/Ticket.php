<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $primaryKey = 'IdBanVe';
    protected $keyType = 'string';

    protected $fillable = [
        'IdBanVe',
        'IdChuyen',
        'IdUser',
        // 'Soluong',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'IdChuyen', 'IdChuyen');
    }

    public function normalUser()
    {
        return $this->belongsTo(NormalUser::class, 'IdUser', 'IdUser');
    }

    public function ticketDetails()
    {
        return $this->hasMany(TicketDetail::class, 'IdBanVe', 'IdBanVe');
    }
}
