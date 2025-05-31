<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laporans')->insert([
            [
                'deskripsi_laporan' => 'ui/ux toilet tidak responsif',
                'status_laporan' => 'belum diproses',
                'tanggal_laporan' => Carbon::now()->toDateString(),
                'soft_delete' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'deskripsi_laporan' => 'Tidak bisa menambahkan toilet favorit',
                'status_laporan' => 'diproses',
                'tanggal_laporan' => Carbon::now()->subDay()->toDateString(),
                'soft_delete' => false,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ]);
    }
}
