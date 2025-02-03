<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sheet_subsheet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sheet_fk')
                  ->constrained('sheets')
                  ->onDelete('cascade');
            $table->foreignId('id_subsheet_fk')
                  ->constrained('sheets')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    
    public function down()
    {
        Schema::dropIfExists('sheet_attribute');
    }
    
};
