<?php

namespace App\Repositories;

use App\Models\TopFiveScore;

class TopFiveFinalistScoreRepository
{
    public function updateOrCreateScore(int $judgeId, int $topFiveId, string $category, $scoreValue)
    {
        $record = TopFiveScore::firstOrNew([
            'judge_id' => $judgeId,
            'top_five_id' => $topFiveId,
        ]);

        $record->{$category} = $scoreValue;

        $record->total_score =
            ($record->top_five_beauty_of_face ?? 0) +
            ($record->top_five_beauty_of_body ?? 0) +
            ($record->top_five_posture_and_carriage_confidence ?? 0) +
            ($record->top_five_final_q_and_a ?? 0);

        $record->save();

        return $record;
    }
}
