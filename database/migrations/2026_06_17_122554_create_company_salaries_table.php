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
        Schema::create('company_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->decimal('gross_salary', 12, 2);

            $table->enum('frequency', [
                'weekly',
                'biweekly',
                'monthly',
            ])->default('monthly');

            $table->date('effective_date');

            $table->boolean('is_current')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_salaries');
    }
};
