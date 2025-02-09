<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'cek_plagiasi_id',
        'token',
        'status',
        'user_id',
    ];

    /**
     * Relasi belongsTo dengan model CekPlagiasi
     */
    public function cekPlagiasi()
    {
        return $this->belongsTo(CekPlagiasi::class, 'cek_plagiasi_id');
    }


    /**
     * Accessor untuk kelas status
     */ 
    public function getStatusClassAttribute()
    {
        $statusClasses = [
            'pending' => 'secondary',
            'in_progress' => 'warning',
            'completed' => 'success',
            'Dalam Proses' => 'warning',
            'Selesai' => 'success',
            'Ditolak' => 'danger',
        ];

        return $statusClasses[$this->status] ?? 'secondary';
    }
    // app/Models/Token.php

public function users()
{
    return $this->belongsToMany(User::class, 'token_user');
}

}
