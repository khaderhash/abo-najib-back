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
        Schema::create('income', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_income');
            $table->double('price');
            $table->enum('category', ['salary', 'bonus', 'investment'])->after('price');




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
