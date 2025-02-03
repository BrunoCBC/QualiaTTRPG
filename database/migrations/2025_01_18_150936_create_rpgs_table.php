<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rpgs', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique();
            $table->string('rpg_name');
            $table->text('rpg_description')->nullable();
            $table->string('rpg_image_path')->nullable();
            $table->enum('visibility', ['public', 'private'])->default('private');
            $table->foreignId('id_folder_fk')->constrained('folders');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rpgs');
    }

};
