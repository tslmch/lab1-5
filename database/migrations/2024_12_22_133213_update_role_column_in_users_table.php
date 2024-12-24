<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Если нужно изменить тип или добавить ограничение
            $table->enum('role', ['user', 'admin'])->default('user')->change();
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Откат изменений
            $table->string('role')->change();
        });
    }
};
