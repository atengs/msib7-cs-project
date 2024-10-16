<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('job_category_code')->nullable();
            $table->string('job_category_name')->nullable();
            $table->boolean('status')->default(true);

            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('master_job_categories')->insert([
            'job_category_code' => 'JCAT001',
            'job_category_name' => 'SMALL',
            'status' => true,
            'created_by' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('master_job_categories')->insert([
            'job_category_code' => 'JCAT002',
            'job_category_name' => 'MEDIUM',
            'status' => true,
            'created_by' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('master_job_categories')->insert([
            'job_category_code' => 'JCAT003',
            'job_category_name' => 'GENERAL',
            'status' => true,
            'created_by' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('master_job_categories')->insert([
            'job_category_code' => 'JCAT004',
            'job_category_name' => 'BIG',
            'status' => true,
            'created_by' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_job_categories');
    }
};
