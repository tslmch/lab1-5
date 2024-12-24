<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Добавление поля user_id с внешним ключом
            $table->unsignedBigInteger('user_id')->nullable();  // Можно указать nullable, если заказ может быть без пользователя

            // Добавление внешнего ключа
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Удаление внешнего ключа и поля
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
