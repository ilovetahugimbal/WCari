<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'toilet_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toilet()
    {
        return $this->belongsTo(Toilet::class);
    }
}