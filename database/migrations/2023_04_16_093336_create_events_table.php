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
        Schema::create('cals', function (Blueprint $table) {
            $table->id();
            $table->biginteger('user_id')->unsigned();
            $table->string('title',10);
            $table->dateTime('date');
            $table->integer('dateid');->default(2);
            $table->integer('timeid');
            $table->integer('importance'); 
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
