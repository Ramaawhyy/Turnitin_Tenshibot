<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'transaksi';

    /**
     * Kolom-kolom yang dapat diisi mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'cek_plagiasi_id',
        'invoice_number',
        'amount',
        'payment_method',
        
    ];

    /**
     * Mendefinisikan relasi ke model CekPlagiasi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cek_plagiasi()
    {
        return $this->belongsTo(CekPlagiasi::class, 'cek_plagiasi_id');
    }

    public function getPaymentMethodDisplayAttribute()
    {
        $paymentMethods = config('payment_methods');

        return $paymentMethods[$this->payment_method] ?? ucfirst(str_replace('_', ' ', strtolower($this->payment_method)));
    }
}
