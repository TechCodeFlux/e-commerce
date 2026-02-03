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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('created_by')->nullable()->after('password');
            $table->boolean('status')->default('0')->after('created_by');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('status');
        });
    }
};

//if need to edit table we need to using the command 

// php artisan make:migration --table=User ---user is table name

// then this current file created

//then edit or add the field to the code on this function: public function up(): void {}

//also add same field to the other function :public function down(): void{} for back up