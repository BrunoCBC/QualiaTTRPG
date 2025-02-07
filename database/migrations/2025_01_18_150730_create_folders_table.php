<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->unique();
            $table->string('folder_name');
            $table->text('folder_description')->nullable();
            $table->string('folder_icon_path')->nullable();
            $table->enum('visibility_role', ['viewer', 'player', 'admin', 'owner'])->default('viewer');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('folders');
    }

};
