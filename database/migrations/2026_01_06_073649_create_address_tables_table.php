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
        Schema::create('address_tables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('club_member_id');
            $table->string('address_line_1');
            $table->string('Address_line_2')->nullable();
            $table->string('Address_line_3')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_tables');
    }
};
