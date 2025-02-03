<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user_fk')->constrained('users');
            $table->morphs('target');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_favorites');
    }
};
