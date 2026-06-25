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
        Schema::create('school_experiences', function (Blueprint $table) {
            $table->id();
            
            $table->string('company');
            $table->string('department')->nullable();
            $table->string('location')->nullable();

            $table->string('event')->nullable();

            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_experiences');
    }
};
