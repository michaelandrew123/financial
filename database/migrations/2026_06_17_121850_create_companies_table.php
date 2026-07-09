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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete(); 
            $table->string('name', 150);
            $table->string('position');
            $table->text('address')->nullable();
            $table->string('email', 150)->nullable(); 
            $table->decimal('gross_salary', 12, 2); 
            $table->enum('frequency', [
                'weekly',
                'biweekly',
                'monthly',
            ])->default('monthly'); 
            $table->date('effective_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
