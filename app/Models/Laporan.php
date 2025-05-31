<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'laporans';
    protected $fillable = [
        'deskripsi_laporan',
        'status_laporan',
        'tanggal_laporan',
        'soft_delete',
    ];

    public function toilet()
    {
        return $this->belongsTo(Toilet::class);
    }
}