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
        Schema::create('selected_themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('group_id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('theme_id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_themes');
    }
};
