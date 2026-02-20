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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suspect_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->string('name');
            $table->string('chapter');
            $table->string('place');
            $table->date('datetime');
            $table->string('decision');
            $table->string('division');
            $table->text('description')->nullable();
//            make new columns for case updated actor from user table
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('evidence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
