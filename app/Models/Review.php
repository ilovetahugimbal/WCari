<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rating',
        'toilet_id',
        'komentar',
        'tanggal_review',
        'created_at',
        'updated_at',
    ];

    public function toilet(): BelongsTo
    {
        return $this->belongsTo(Toilet::class);
    }
}
