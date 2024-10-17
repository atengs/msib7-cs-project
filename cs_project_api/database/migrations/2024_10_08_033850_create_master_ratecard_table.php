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
        Schema::create('master_ratecard', function (Blueprint $table) {
            $table->id();
            $table->string('category_code')->nullable();
            $table->string('job_category_code')->nullable();
            $table->string('job_description')->nullable();
            $table->double('ratecard', 16,2)->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('status')->default(true);

            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_ratecard');
    }
};
