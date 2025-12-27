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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('resume');
            $table->string('annee', 4);
            $table->string('type'); // 'article', 'conference', 'chapitre'
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('research_team_id');
            $table->unsignedBigInteger('category_id');
            $table->string('journal');
            $table->string('fichier_pdf')->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('research_team_id')
                  ->references('id')
                  ->on('research_teams')
                  ->onDelete('cascade');

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};