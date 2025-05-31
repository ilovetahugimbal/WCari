<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'toilet_id' => 1,
                'rating' => 4,
                'komentar' => 'Toiletnya bersih dan wangi!',
                'tanggal_review' => Carbon::now()->toDateString(),
                'soft_delete' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'toilet_id' => 1,
                'rating' => 2,
                'komentar' => 'Cukup bersih, tapi air kadang habis.',
                'tanggal_review' => Carbon::now()->subDay()->toDateString(),
                'soft_delete' => false,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'toilet_id' => 2,
                'rating' => 5,
                'komentar' => 'Fasilitas lengkap dan nyaman!',
                'tanggal_review' => Carbon::now()->toDateString(),
                'soft_delete' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Generate additional reviews using factory
        //Review::factory(30)->create();
    }
}