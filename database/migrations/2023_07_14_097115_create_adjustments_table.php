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
        Schema::create('adjustments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->decimal('mri', 20, 2)->nullable() ; 
            $table->decimal('interest_rebate', 20, 2)->nullable() ;
            $table->decimal('previous_loan_balance', 20, 2)->nullable() ;
            $table->decimal('interest_first_yr', 20, 2)->nullable() ;
            $table->decimal('housing_service_fee', 20, 2)->nullable() ;
            $table->decimal('previous_penalty', 20, 2)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjustments');
    }
};
