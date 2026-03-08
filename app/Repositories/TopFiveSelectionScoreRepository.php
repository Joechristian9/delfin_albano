<?php

namespace App\Repositories;

use App\Models\TopFiveSelectionScore;

class TopFiveSelectionScoreRepository
{
    public function updateOrCreateScore(int $judgeId, int $candidateId, string $category, $scoreValue)
    {
        $record = TopFiveSelectionScore::firstOrNew([
            'judge_id' => $judgeId,
            'candidate_id' => $candidateId,
        ]);

        $record->{$category} = $scoreValue;

        $record->total_score =
            ($record->creative_attire ?? 0) +
            ($record->casual_wear ?? 0) +
            ($record->swim_wear ?? 0) +
            ($record->filipiniana_attire ?? 0) +
            ($record->beauty_of_face_aura ?? 0) +
            ($record->beauty_of_body ?? 0) +
            ($record->posture_and_carriage_confidence ?? 0);

        $record->save();

        return $record;
    }
}
