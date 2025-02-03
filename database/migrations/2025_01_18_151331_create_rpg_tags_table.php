<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rpg_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rpg_fk')
                  ->constrained('rpgs')
                  ->onDelete('cascade');
            $table->foreignId('id_tag_fk')
                  ->constrained('tags')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    
    
    public function down()
    {
        Schema::dropIfExists('rpg_tags');
    }
    
};
