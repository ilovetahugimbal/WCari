<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Toilet;

class FavoriteSeeder extends Seeder
{
    public function run()
    {
        // Get first user and first toilet
        $user = User::first();
        $toilet = Toilet::first();

        // Create favorite
        Favorite::create([
            'user_id' => $user->id,
            'toilet_id' => $toilet->id
        ]);
    }
}