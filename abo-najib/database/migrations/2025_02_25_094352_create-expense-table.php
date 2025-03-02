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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_expense');
            $table->double('price');
            $table->enum('category', ['salary', 'bonus', 'investment'])->after('price');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // الربط بالمستخدم
            $table->timestamp('date')->nullable();  // إضافة عمود date من النوع timestamp
            $table->timestamps();  // إضافة الأعمدة created_at و updated_at




        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);  // حذف الأعمدة في حالة التراجع عن المهاجرة
        });    }
};
