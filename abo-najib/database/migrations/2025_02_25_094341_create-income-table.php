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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_income');
            $table->double('price');
            $table->enum('category', ['salary', 'bonus', 'investment'])->after('price');
            $table->foreignId('income_id')->constrained('users')->onDelete('cascade');




        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
