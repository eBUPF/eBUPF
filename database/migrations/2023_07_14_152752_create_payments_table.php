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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('loan_id')->constrained('loans');

            $table->integer('or_number');
            $table->decimal('principal', 20, 2);
            $table->decimal('interest', 20, 2);
            $table->date('payment_date');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
