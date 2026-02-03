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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('stock')->default('0');
            $table->string('image')->nullable();
            $table->string('description');
            $table->unsignedBigInteger('option_id')->default('0');
            $table->unsignedBigInteger('microsite_id')->default('0');
            $table->unsignedBigInteger('category_id')->default('0');
            $table->unsignedBigInteger('club_id')->default('0');
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
       Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
    }); 
}
};
