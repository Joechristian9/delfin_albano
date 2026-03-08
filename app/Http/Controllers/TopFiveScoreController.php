<?php

namespace App\Http\Controllers;

use App\Repositories\TopFiveFinalistScoreRepository;
use App\Models\TopFiveCandidates;
use Illuminate\Http\Request;

class TopFiveScoreController extends Controller
{
    protected $scores;

    public function __construct(TopFiveFinalistScoreRepository $scores)
    {
        $this->scores = $scores;
    }

    public function beautyOfFaceStore(Request $request)
    {
        $request->validate([
            'judge_id' => 'required|exists:users,id',
            'scores'   => 'required|array',
        ]);

        foreach ($request->scores as $candidateId => $scoreValue) {

            $topFive = TopFiveCandidates::where('candidate_id', $candidateId)->first();

            if (!$topFive) continue;

            $this->scores->updateOrCreateScore(
                $request->judge_id,
                $topFive->id,
                'top_five_beauty_of_face',
                $scoreValue
            );
        }

        return back()->with('success', 'Beauty of Face scores saved successfully.');
    }


    public function beautyOfBodyStore(Request $request)
    {
        $request->validate([
            'judge_id' => 'required|exists:users,id',
            'scores'   => 'required|array',
        ]);

        foreach ($request->scores as $candidateId => $scoreValue) {

            $topFive = TopFiveCandidates::where('candidate_id', $candidateId)->first();

            if (!$topFive) continue;

            $this->scores->updateOrCreateScore(
                $request->judge_id,
                $topFive->id,
                'top_five_beauty_of_body',
                $scoreValue
            );
        }

        return back()->with('success', 'Beauty of Body scores saved successfully.');
    }


    public function postureAndCarriageConfidenceStore(Request $request)
    {
        $request->validate([
            'judge_id' => 'required|exists:users,id',
            'scores'   => 'required|array',
        ]);

        foreach ($request->scores as $candidateId => $scoreValue) {

            $topFive = TopFiveCandidates::where('candidate_id', $candidateId)->first();

            if (!$topFive) continue;

            $this->scores->updateOrCreateScore(
                $request->judge_id,
                $topFive->id,
                'top_five_posture_and_carriage_confidence',
                $scoreValue
            );
        }

        return back()->with('success', 'Posture and Carriage / Confidence scores saved successfully.');
    }


    public function finalQAStore(Request $request)
    {
        $request->validate([
            'judge_id' => 'required|exists:users,id',
            'scores'   => 'required|array',
        ]);

        foreach ($request->scores as $candidateId => $scoreValue) {

            $topFive = TopFiveCandidates::where('candidate_id', $candidateId)->first();

            if (!$topFive) continue;

            $this->scores->updateOrCreateScore(
                $request->judge_id,
                $topFive->id,
                'top_five_final_q_and_a',
                $scoreValue
            );
        }

        return back()->with('success', 'Final Q & A scores saved successfully.');
    }
}
