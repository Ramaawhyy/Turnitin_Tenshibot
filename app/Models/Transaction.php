<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'cek_plagiasi_id',
        'user_id',
        'amount',
        'status',
        'payment_reference',
    ];

    public function cekPlagiasi()
    {
        return $this->belongsTo(CekPlagiasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
