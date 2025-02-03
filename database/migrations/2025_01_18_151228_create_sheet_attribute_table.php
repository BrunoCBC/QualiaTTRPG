<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sheet_attribute', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sheet_fk')->constrained('sheets')->onDelete('cascade');
            $table->foreignId('id_attribute_fk')->constrained('attributes')->onDelete('cascade');
            $table->integer('points_spent');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sheet_attribute');
    }
};
