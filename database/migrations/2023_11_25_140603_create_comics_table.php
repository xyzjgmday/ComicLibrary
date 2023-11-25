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
        Schema::create('comics', function (Blueprint $table) {
            $table->id('comic_id');
            $table->string('title');
            $table->string('author');
            $table->string('genre');
            $table->text('description');
            $table->date('release_date');
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};
