<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('title'); // título del video
            $table->text('description'); // descripción, opcional
            $table->string('url'); // URL del video
            $table->timestamp('published_at')->nullable(); // fecha de publicación, opcional
            $table->string('previous')->nullable(); // referencia al video anterior
            $table->string('next')->nullable(); // referencia al video siguiente
            $table->foreignId('series_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps(); // created_at y updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
