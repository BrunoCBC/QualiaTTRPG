<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rpg_level_sheettype', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rpg_fk')
                  ->constrained('rpgs')
                  ->onDelete('cascade');
            $table->foreignId('id_level_fk')
                  ->constrained('levels')
                  ->onDelete('cascade');
            $table->foreignId('id_sheettype_fk')
                  ->constrained('sheet_types')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    
    public function down()
    {
        Schema::dropIfExists('rpg_level_sheettype');
    }
    
};
