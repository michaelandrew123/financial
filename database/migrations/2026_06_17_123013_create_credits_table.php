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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->string('title');

            $table->decimal('original_amount', 12, 2);
            $table->decimal('remaining_balance', 12, 2);
            $table->decimal('monthly_payment', 12, 2);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->enum('status', [
                'active',
                'paid',
                'overdue',
                'restructured',
                'cancelled'
            ])->default('active');


            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
