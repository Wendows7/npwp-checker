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
        Schema::table('suspects', function (Blueprint $table) {
            $table->string('place_of_birth')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->integer('age')->nullable()->change();
            $table->string('religion')->nullable()->change();
            $table->string('education')->nullable()->change();
            $table->string('occupation')->nullable()->change();
            $table->string('address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suspects', function (Blueprint $table) {
            //
        });
    }
};
