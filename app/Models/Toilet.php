<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toilet extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'facilities' => 'array',
        'access' => 'array',
    ];

    public function reviews() {
        return $this->hasMany(Review::class);
    }
    
    public function getAverageRatingAttribute()
    {
        return $this->reviews_avg_rating ?? 0;;
    }
    
    protected $attributes = [
        'photo' => '["images/image1.jpg","images/image2.jpg"]',
    ];

    public function getRatingStars()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= '<i class="fas fa-star ' . ($this->rating >= $i ? 'text-yellow-400' : 'text-slate-300') . '"></i>';
        }
        return $stars;
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function favorites()
{
    return $this->hasMany(Favorite::class);
}

public function isFavoritedByUser($userId)
{
    return $this->favorites->contains('user_id', $userId);
}
}