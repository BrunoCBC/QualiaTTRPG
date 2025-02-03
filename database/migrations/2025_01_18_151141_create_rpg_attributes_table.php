<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rpg_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rpg_fk')
                  ->constrained('rpgs')
                  ->onDelete('cascade');
            $table->foreignId('id_attribute_fk')
                  ->constrained('attributes')
                  ->onDelete('cascade');
        });
    }
    
    
    public function down()
    {
        Schema::dropIfExists('rpg_attributes');
    }
    
};
