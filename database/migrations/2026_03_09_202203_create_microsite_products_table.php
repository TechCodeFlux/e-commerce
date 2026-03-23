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
        Schema::create('microsite_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('microsite_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('varient_id');
            $table->unsignedBigInteger('club_id');
            $table->boolean('status')->default('0');
            $table->softdeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('microsite_products');
    }
};
