<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            // Change column types to match countries.id and states.id
            $table->unsignedBigInteger('country_id')->change();
            $table->unsignedBigInteger('state_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->integer('country_id')->change();
            $table->string('state_id')->change();
        });
    }
};
