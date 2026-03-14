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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('supply_type', ['electricity', 'gas']);
            $table->decimal('consumption', 10, 6);
            $table->enum('consumption_unit', ['kWh', 'Smc']);
            $table->decimal('total_amount', 10, 2);
            $table->date('period_start');
            $table->date('period_end');
            $table->string('provider_name');               
            $table->string('invoice_number')->nullable();
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
