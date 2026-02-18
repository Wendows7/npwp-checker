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
        Schema::create('suspects', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('alias');
            $table->string('gender');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->integer('age');
            $table->string('religion');
            $table->string('education');
            $table->string('occupation');
            $table->string('address');
            $table->string('finger_code')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspects');
    }
};
