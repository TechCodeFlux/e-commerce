<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('microsites', function (Blueprint $table) {
    $table->id();
    $table->foreignId('club_id')->constrained()->onDelete('cascade');
    $table->string('event_name');
    $table->text('description')->nullable();
    $table->string('banner')->nullable();
    $table->date('start_date');
    $table->date('end_date');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('microsites');
    }
};
