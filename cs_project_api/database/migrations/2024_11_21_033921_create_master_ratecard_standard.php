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
        Schema::create('master_ratecard_standard', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ratecard_id')->nullable();
            $table->double('cost', 16,2)->nullable();
            $table->timestamps(); 
            $table->softDeletes();

            $table->foreign('ratecard_id')
            ->references('id')
            ->on('master_ratecard')
            ->onUpdate('cascade')
            ->onDelete('cascade');
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_ratecard_standard');
    }
};
