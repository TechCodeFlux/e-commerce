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
        Schema::create('product_tables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('stock');
            $table->integer('option_table_id');
            $table->integer('option_value_id');
            $table->string('description');
            $table->boolean('status');
            $table->integer('microsite_id');
            $table->integer('category_id');
            $table->integer('club_id');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tables');
    }
};
