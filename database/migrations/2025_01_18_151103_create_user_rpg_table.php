<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_rpg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user_fk')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('id_rpg_fk')
                  ->constrained('rpgs')
                  ->onDelete('cascade');
            $table->foreignId('id_sheet_fk')
                  ->nullable()
                  ->constrained('sheets')
                  ->onDelete('set null');
            $table->enum('role', ['viewer', 'player', 'admin', 'owner']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_rpg');
    }
};
