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
            $table->unsignedBigInteger('series_id'); // referencia a la serie, sin clave foránea
            $table->timestamps(); // created_at y updated_at

            // Clave foránea será agregada más adelante
            // $table->foreign('series_id')->references('id')->on('series')->cascadeOnDelete();
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
