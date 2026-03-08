<?php

namespace App\Http\Controllers;

use App\Models\TopFiveCandidates;
use App\Models\TopFiveScore;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TopFiveCandidateController extends Controller
{
    private function getTopFiveCandidatesWithScores(string $field)
    {
        $judgeId = Auth::id();

        return TopFiveCandidates::with('candidate')
            ->get()
            ->sortBy(fn($item) => $item->candidate->candidate_number ?? 0)
            ->values()
            ->map(function ($item) use ($judgeId, $field) {
                $topFiveScore = TopFiveScore::where('top_five_id', $item->id)
                    ->where('judge_id', $judgeId)
                    ->first();

                return [
                    'id' => $item->id,
                    'candidate_number' => $item->candidate->candidate_number ?? null,
                    'candidate_id' => $item->candidate_id,
                    'profile_img' => $item->candidate->profile_img ?? null,
                    'first_name' => $item->candidate->first_name ?? null,
                    'last_name' => $item->candidate->last_name ?? null,
                    'course' => $item->candidate->course ?? null,
                    $field => $topFiveScore?->{$field},
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });
    }

    public function beautyOfFace()
    {
        return Inertia::render('Categories/TopFiveCategories/BeautyOfFace', [
            'candidates' => $this->getTopFiveCandidatesWithScores('top_five_beauty_of_face'),
            'categoryName' => 'Beauty of Face',
            'category' => 'top_five_beauty_of_face',
        ]);
    }

    public function beautyOfBody()
    {
        return Inertia::render('Categories/TopFiveCategories/BeautyOfBody', [
            'candidates' => $this->getTopFiveCandidatesWithScores('top_five_beauty_of_body'),
            'categoryName' => 'Beauty of Body',
            'category' => 'top_five_beauty_of_body',
        ]);
    }

    public function postureAndCarriageConfidence()
    {
        return Inertia::render('Categories/TopFiveCategories/PostureAndCarriageConfidence', [
            'candidates' => $this->getTopFiveCandidatesWithScores('top_five_posture_and_carriage_confidence'),
            'categoryName' => 'Posture and Carriage / Confidence',
            'category' => 'top_five_posture_and_carriage_confidence',
        ]);
    }

    public function final_q_and_a()
    {
        return Inertia::render('Categories/TopFiveCategories/FinalQA', [
            'candidates' => $this->getTopFiveCandidatesWithScores('top_five_final_q_and_a'),
            'categoryName' => 'Final Q and A',
            'category' => 'top_five_final_q_and_a',
        ]);
    }
}
