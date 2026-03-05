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
    Schema::table('microsite', function (Blueprint $table) {
        $table->string('slug',191)->unique()->after('name');
    });
}

public function down(): void
{
    Schema::table('microsite', function (Blueprint $table) {
        $table->dropColumn('slug',191);
    });
}
};
