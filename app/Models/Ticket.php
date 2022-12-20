<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Ticket extends Model
{
    use HasFactory, Sortable;
    protected $primaryKey = 'IdBanVe';
    protected $keyType = 'string';

    protected $fillable = [
        'IdBanVe',
        'IdChuyen',
        'IdUser',
        'created_at',
        'updated_at',
        // 'Soluong',
    ];

    public $sortable = [
        'IdBanVe',
        'IdChuyen',
        'IdUser',
        // 'Soluong',
    ];

    public $timestamps = true;

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
