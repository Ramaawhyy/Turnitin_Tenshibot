<?php

// File: app/Models/CekPlagiasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Token; // Import model Token

class CekPlagiasi extends Model
{
    use HasFactory;

    protected $table = 'cek_plagiasi'; // Pastikan nama tabel sudah benar

    protected $fillable = [
        'judul',
        'nomor_hp',
        'profilenama', // Tambahkan ini
        'exclude_daftar_pustaka',
        'exclude_kutipan',
        'exclude_match_percentage',
        'exclude_match_words',
        'dokumen',
        'link_dokumen',
        'user_id',
        'google_drive_file_id',
        'status_pembayaran', 
        'is_edited',
    ];

    /**
     * Relasi one-to-one dengan model Token
     */
    public function token()
    {
        return $this->hasOne(Token::class, 'cek_plagiasi_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'cek_plagiasi_id');
    }

    public function transaksis()
{
    return $this->hasMany(Transaksi::class, 'cek_plagiasi_id');
}

    
}
