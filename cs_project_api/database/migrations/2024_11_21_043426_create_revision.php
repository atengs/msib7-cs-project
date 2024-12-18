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
        Schema::create('revision', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->nullable();
            $table->string('revision_note')->nullable();
            $table->date('revision_date')->nullable();
            $table->timestamps();

            $table->foreign('transaction_number')
            ->references('trans_number')
            ->on('transaction_header')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision');
    }
};
