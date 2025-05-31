<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('toilet_id')->constrained('toilets')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'toilet_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};