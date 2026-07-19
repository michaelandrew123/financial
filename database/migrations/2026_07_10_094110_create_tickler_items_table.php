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
        Schema::create('tickler_items', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('tickler_id')->constrained()->cascadeOnDelete(); 
            $table->json('items');
            $table->string('approved_by_name')->nullable();  
            $table->text('approved_by_signature_path')->nullable(); 
            $table->text('signature_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickler_items');
    }
};
