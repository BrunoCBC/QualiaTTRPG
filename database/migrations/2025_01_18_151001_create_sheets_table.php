<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sheets', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique();
            $table->string('sheet_name');
            $table->text('sheet_description')->nullable();
            $table->integer('sheet_level');
            $table->string('sheet_image_path')->nullable();
            $table->foreignId('id_folder_fk')->constrained('folders')->onDelete('cascade');
            $table->foreignId('id_sheettype_fk')->constrained('sheet_types')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('sheets');
    }
};
