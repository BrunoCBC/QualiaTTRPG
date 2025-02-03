<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('folder_subfolder', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_folder_fk')
                ->constrained('folders')
                ->onDelete('cascade');
            $table->foreignId('id_subfolder_fk')
                ->constrained('folders')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('folder_subfolder');
    }
    
};
