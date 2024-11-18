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
        Schema::create('transaction_detail', function (Blueprint $table) {
            $table->id();
            $table->string('trans_number');
            $table->integer('ratecard_id')->nullable();
            $table->double('ratecard_nominal',15,2)->nullable();
            $table->text('note')->nullable();
            $table->string('business_type', 50)->nullable();
            $table->integer('qty')->default(1);
 
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();

            $table->foreign('trans_number')
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
        Schema::dropIfExists('transaction_detail');
    }
};
