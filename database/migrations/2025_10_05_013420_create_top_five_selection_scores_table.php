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
        Schema::create('top_five_selection_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidate_id')
                ->constrained('candidates')
                ->onDelete('cascade');
            $table->foreignId('judge_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->decimal('creative_attire', 5, 2)->nullable();
            $table->decimal('casual_wear', 5, 2)->nullable();
            $table->decimal('swim_wear', 5, 2)->nullable();
            $table->decimal('filipiniana_attire', 5, 2)->nullable();
            $table->decimal('beauty_of_face_aura', 5, 2)->nullable();
            $table->decimal('beauty_of_body', 5, 2)->nullable();
            $table->decimal('posture_and_carriage_confidence', 5, 2)->nullable();
            $table->decimal('total_score', 6, 2)->nullable();
            $table->timestamps();
            $table->unique(['candidate_id', 'judge_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_five_selection_scores');
    }
};
