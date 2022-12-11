<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $primaryKey = 'IdDiaDiem';
    protected $keyType = 'string';

    protected $fillable = [
        'TenDiaDiem',
        'slider_img',
        'content_img',
    ];
}
