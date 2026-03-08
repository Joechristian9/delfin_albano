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
        Schema::create('top_five_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('top_five_id')
                ->constrained('top_five_candidates', 'id')
                ->onDelete('cascade');

            $table->foreignId('judge_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->decimal('top_five_beauty_of_face', 5, 2)->nullable();
            $table->decimal('top_five_beauty_of_body', 5, 2)->nullable();
            $table->decimal('top_five_posture_and_carriage_confidence', 5, 2)->nullable();
            $table->decimal('top_five_final_q_and_a', 5, 2)->nullable();

            $table->decimal('total_score', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_five_scores');
    }
};
