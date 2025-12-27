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
        Schema::create('research_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('domaine');
            $table->unsignedBigInteger('team_leader_id')->nullable();
            $table->timestamps();

            // Clé étrangère vers users
            $table->foreign('team_leader_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_teams');
    }
};