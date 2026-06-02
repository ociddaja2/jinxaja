<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'peminjamans';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'alat_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_realisasi',
        'status',
        'catatan',
    ];

    /**
     * Get the user that owns the peminjaman.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the alat that is being borrowed.
     */
    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class);
    }
}
