<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique();
            $table->string('file_name');
            $table->text('file_description')->nullable();
            $table->string('file_path');
            $table->string('file_preview_path')->nullable();
            $table->foreignId('id_folder_fk')->constrained('folders')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
