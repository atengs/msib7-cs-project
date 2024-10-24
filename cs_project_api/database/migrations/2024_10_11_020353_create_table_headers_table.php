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
        Schema::create('transaction_header', function (Blueprint $table) {
            $table->id();
            $table->string('trans_number')->unique();
            $table->string('customer')->nullable();
            $table->date('trans_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->string('address')->nullable();
            $table->string('project')->nullable();
            $table->string('job')->nullable();
            $table->string('acount_executive')->nullable();
            $table->string('acount_manager')->nullable();
            $table->string('finance_manager')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_header');
    }
};
