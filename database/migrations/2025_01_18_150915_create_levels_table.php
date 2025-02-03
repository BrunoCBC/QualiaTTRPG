<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->integer('level');
            $table->integer('pc');
            $table->integer('pl');
            $table->integer('pm');
            $table->integer('pb');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('levels');
    }

};
