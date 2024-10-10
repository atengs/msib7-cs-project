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
        Schema::create('master_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_code')->nullable();
            $table->string('category_name')->unique()->nullable();
            $table->string('category_prefix')->nullable();
            $table->boolean('status')->default(true);
            
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('master_categories')->insert([
            'category_code' => 'CAT001',
            'category_name' => 'ABOVE THE LINE',
            'category_prefix' => 'ATL',
            'status' => true,
            'created_by' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('master_categories')->insert([
            'category_code' => 'CAT002',
            'category_name' => 'DIGITAL',
            'category_prefix' => 'DTL',
            'status' => true,
            'created_by' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('master_categories')->insert([
            'category_code' => 'CAT003',
            'category_name' => 'BELLOW THE LINE',
            'category_prefix' => 'BTL',
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
        Schema::dropIfExists('master_categories');
    }
};
