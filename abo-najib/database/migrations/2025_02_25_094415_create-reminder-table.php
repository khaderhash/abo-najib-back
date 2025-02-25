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
        Schema::create('reminder', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('time');
            $table->double('price');
            $table->foreignId('goal_reminder')->constrained('users');




        });      }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
