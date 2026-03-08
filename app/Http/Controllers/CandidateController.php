<?php

namespace App\Http\Controllers;

use App\Repositories\CandidateRepository;
use App\Models\TopFiveSelectionScore;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CandidateController extends Controller
{
    protected $candidates;

    public function __construct(CandidateRepository $candidates)
    {
        $this->candidates = $candidates;
    }

    protected function renderCategory(string $view, string $categoryField)
    {
        $candidates = $this->candidates->all();
        $user = Auth::user();
        $judgeId = $user->id;

        $scores = TopFiveSelectionScore::where('judge_id', $judgeId)
            ->pluck($categoryField, 'candidate_id');

        foreach ($candidates as $candidate) {
            $candidate->existing_score = $scores[$candidate->id] ?? null;
        }

        return Inertia::render($view, [
            'candidates' => $candidates,
        ]);
    }

    public function creative_attire()
    {
        return $this->renderCategory(
            'Categories/CreativeAttire',
            'creative_attire'
        );
    }

    public function casual_wear()
    {
        return $this->renderCategory(
            'Categories/CasualWear',
            'casual_wear'
        );
    }

    public function swim_wear()
    {
        return $this->renderCategory(
            'Categories/SwimWear',
            'swim_wear'
        );
    }

    public function filipiniana_attire()
    {
        return $this->renderCategory(
            'Categories/FilipinianaAttire',
            'filipiniana_attire'
        );
    }

    public function beauty_of_face_aura()
    {
        return $this->renderCategory(
            'Categories/BeautyOfFaceAura',
            'beauty_of_face_aura'
        );
    }

    public function beauty_of_body()
    {
        return $this->renderCategory(
            'Categories/BeautyOfBody',
            'beauty_of_body'
        );
    }

    public function posture_and_carriage_confidence()
    {
        return $this->renderCategory(
            'Categories/PostureAndCarriageConfidence',
            'posture_and_carriage_confidence'
        );
    }
}
