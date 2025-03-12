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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('time')->nullable();
            $table->double('price');
            $table->enum('category', ['Travel', 'Savings', 'Education']);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // الربط بالمستخدم
            $table->timestamps(); // إضافة created_at و updated_at
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals'); // إصلاح عملية التراجع عن الميجريشن
    }
};
