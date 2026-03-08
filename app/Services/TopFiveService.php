<?php

namespace App\Services;

use App\Models\TopFiveScore;
use App\Models\TopFiveCandidates;

class TopFiveService
{
    protected array $categories = [
        'accumulative',
        'top_five_beauty_of_face',
        'top_five_beauty_of_body',
        'top_five_posture_and_carriage_confidence',
        'top_five_final_q_and_a',
    ];

    protected array $judgeOrder = [
        'judge_1',
        'judge_2',
        'judge_3',
        'judge_4',
        'judge_5',
    ];

    /**
     * Get results per category
     */
    public function getResultsPerCategory(string $category): array
    {
        $candidatesList = TopFiveCandidates::with('candidate')
            ->get()
            ->map(fn($item) => [
                'candidate'   => $item->candidate,
                'top_five_id' => $item->id,
                'accumulative' => $item->accumulative ?? 0,
            ]);

        $scores = TopFiveScore::with('judge')->get();

        return [
            'candidates' => $this->processCandidates(
                $candidatesList,
                $scores,
                $category,
                $this->judgeOrder
            ),
            'judgeOrder' => $this->judgeOrder,
        ];
    }

    protected function processCandidates($candidatesList, $scores, string $category, array $judgeOrder): array
    {
        $processed = [];

        foreach ($candidatesList as $index => $item) {
            $candidate = $item['candidate'];
            $topFiveId = $item['top_five_id'];
            $accumulative = $item['accumulative'];

            $candidateScores = array_fill_keys($judgeOrder, 0);

            if ($category === 'accumulative') {
                $candidateScores['judge_1'] = round($accumulative, 2);

                $processed[] = [
                    'candidate'        => $candidate,
                    'scores'           => $candidateScores,
                    'total'            => round($accumulative, 2),
                    'rank'             => 0,
                    'candidate_number' => $index + 1,
                ];

                continue;
            }

            foreach ($scores->where('top_five_id', $topFiveId) as $score) {
                if ($score->judge && in_array($score->judge->name, $judgeOrder)) {
                    $candidateScores[$score->judge->name] = $score->{$category} ?? 0;
                }
            }

            $processed[] = [
                'candidate'        => $candidate,
                'scores'           => $candidateScores,
                'total'            => round(array_sum($candidateScores), 2),
                'rank'             => 0,
                'candidate_number' => $index + 1,
            ];
        }

        return $this->assignRanking($processed);
    }

    /**
     * Get total combined results
     */
    public function getTotalResults(): array
    {
        $candidates = TopFiveCandidates::with('candidate')->get();
        $scores = TopFiveScore::with('judge')->get();

        $processed = [];

        foreach ($candidates as $index => $item) {
            $beautyOfFace = 0;
            $beautyOfBody = 0;
            $postureAndCarriage = 0;
            $finalQA = 0;

            foreach ($scores->where('top_five_id', $item->id) as $score) {
                $beautyOfFace += $score->top_five_beauty_of_face ?? 0;
                $beautyOfBody += $score->top_five_beauty_of_body ?? 0;
                $postureAndCarriage += $score->top_five_posture_and_carriage_confidence ?? 0;
                $finalQA += $score->top_five_final_q_and_a ?? 0;
            }

            $accumulative = $item->accumulative ?? 0;

            $processed[] = [
                'candidate' => $item->candidate,
                'scores' => [
                    'accumulative' => round($accumulative, 2),
                    'top_five_beauty_of_face' => round($beautyOfFace, 2),
                    'top_five_beauty_of_body' => round($beautyOfBody, 2),
                    'top_five_posture_and_carriage_confidence' => round($postureAndCarriage, 2),
                    'top_five_final_q_and_a' => round($finalQA, 2),
                ],
                'total' => round(
                    $accumulative +
                        $beautyOfFace +
                        $beautyOfBody +
                        $postureAndCarriage +
                        $finalQA,
                    2
                ),
                'rank' => 0,
                'candidate_number' => $index + 1,
            ];
        }

        return [
            'candidates' => $this->assignRanking($processed),
            'judgeOrder' => [],
        ];
    }

    protected function processTotalPerCategory($candidatesList, $scores): array
    {
        $processed = [];

        foreach ($candidatesList as $index => $item) {
            $candidate = $item['candidate'];
            $topFiveId = $item['top_five_id'];
            $accumulative = $item['accumulative'] ?? 0;

            $categoryTotals = array_fill_keys($this->categories, 0);
            $categoryTotals['accumulative'] = $accumulative;

            foreach ($scores->where('top_five_id', $topFiveId) as $score) {
                foreach ($this->categories as $cat) {
                    if ($cat === 'accumulative') {
                        continue;
                    }

                    $categoryTotals[$cat] += $score->{$cat} ?? 0;
                }
            }

            $processed[] = [
                'candidate'        => $candidate,
                'scores'           => $categoryTotals,
                'total'            => round(array_sum($categoryTotals), 2),
                'rank'             => 0,
                'candidate_number' => $index + 1,
            ];
        }

        return $this->assignRanking($processed);
    }

    private function assignRanking(array $candidates): array
    {
        usort($candidates, fn($a, $b) => $b['total'] <=> $a['total']);

        $rank = 1;
        $lastTotal = null;

        foreach ($candidates as $index => &$c) {
            if ($lastTotal !== null && $c['total'] === $lastTotal) {
                $c['rank'] = $rank;
            } else {
                $rank = $index + 1;
                $c['rank'] = $rank;
                $lastTotal = $c['total'];
            }
        }

        return $candidates;
    }
}
