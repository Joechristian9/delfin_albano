<?php

namespace App\Http\Controllers;

use App\Repositories\TopFiveSelectionScoreRepository;
use Illuminate\Http\Request;

class TopFiveSelectionScoreController extends Controller
{
    protected $scores;

    public function __construct(TopFiveSelectionScoreRepository $scores)
    {
        $this->scores = $scores;
    }

    private function storeScores(Request $request, string $category)
    {
        $request->validate([
            'judge_id' => 'required|exists:users,id',
            'scores' => 'required|array',
        ]);

        $judgeId = $request->input('judge_id');
        $scores = $request->input('scores');

        foreach ($scores as $candidateId => $scoreValue) {
            $this->scores->updateOrCreateScore(
                $judgeId,
                $candidateId,
                $category,
                $scoreValue
            );
        }

        return back()->with('success', ucfirst(str_replace('_', ' ', $category)) . ' scores saved successfully.');
    }

    public function creative_attire_store(Request $request)
    {
        return $this->storeScores($request, 'creative_attire');
    }

    public function casual_wear_store(Request $request)
    {
        return $this->storeScores($request, 'casual_wear');
    }

    public function swim_wear_store(Request $request)
    {
        return $this->storeScores($request, 'swim_wear');
    }

    public function filipiniana_attire_store(Request $request)
    {
        return $this->storeScores($request, 'filipiniana_attire');
    }

    public function beauty_of_face_aura_store(Request $request)
    {
        return $this->storeScores($request, 'beauty_of_face_aura');
    }

    public function beauty_of_body_store(Request $request)
    {
        return $this->storeScores($request, 'beauty_of_body');
    }

    public function posture_and_carriage_confidence_store(Request $request)
    {
        return $this->storeScores($request, 'posture_and_carriage_confidence');
    }
}
