<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sheet_types', function (Blueprint $table) {
            $table->id();
            $table->string('sheettype_name');
            $table->text('sheettype_description')->nullable();
            $table->unsignedBigInteger('id_rpg_fk');
            $table->timestamps();
    
            $table->foreign('id_rpg_fk')->references('id')->on('rpgs')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('sheet_types');
    }
};
