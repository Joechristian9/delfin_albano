<?php

namespace App\Http\Controllers\ResultController;

use App\Http\Controllers\Controller;
use App\Services\TopFiveSelectionService;
use App\Models\TopFiveCandidates;
use Inertia\Inertia;

class TopFiveSelectionResultController extends Controller
{
    protected $service;

    public function __construct(TopFiveSelectionService $service)
    {
        $this->service = $service;
    }

    private function renderCategory(string $category, string $name, string $view)
    {
        $results = $this->service->getResultsPerCategory($category);

        return Inertia::render($view, [
            'candidates'   => $results['candidates'],
            'judgeOrder'   => $results['judgeOrder'],
            'categoryName' => $name,
        ]);
    }

    public function creativeAttireResults()
    {
        return $this->renderCategory(
            'creative_attire',
            'Bangkarera Creative Attire',
            'Admin/CreativeAttireResult'
        );
    }

    public function casualWearResults()
    {
        return $this->renderCategory(
            'casual_wear',
            'Casual Wear',
            'Admin/CasualWearResult'
        );
    }

    public function swimWearResults()
    {
        return $this->renderCategory(
            'swim_wear',
            'Swim Wear',
            'Admin/SwimWearResult'
        );
    }

    public function filipinianaAttireResults()
    {
        return $this->renderCategory(
            'filipiniana_attire',
            'Filipiniana Attire',
            'Admin/FilipinianaAttireResult'
        );
    }

    public function beautyOfFaceAuraResults()
    {
        return $this->renderCategory(
            'beauty_of_face_aura',
            'Beauty of Face / Aura',
            'Admin/BeautyOfFaceAuraResult'
        );
    }

    public function beautyOfBodyResults()
    {
        return $this->renderCategory(
            'beauty_of_body',
            'Beauty of Body',
            'Admin/BeautyOfBodyResult'
        );
    }

    public function postureAndCarriageConfidenceResults()
    {
        return $this->renderCategory(
            'posture_and_carriage_confidence',
            'Posture and Carriage / Confidence',
            'Admin/PostureAndCarriageConfidenceResult'
        );
    }

    public function topFiveSelectionResults()
    {
        $results = $this->service->getTopFiveSelectionResults();

        return Inertia::render('Admin/TopFiveSelectionResult', [
            'candidates'   => $results['candidates'],
            'categories'   => $results['categories'],
            'categoryName' => 'Top Five Selection',
        ]);
    }

    public function setTopFive()
    {
        TopFiveCandidates::query()->delete();

        $topFive = $this->service->getTopFiveAccumulative();

        foreach ($topFive as $data) {
            TopFiveCandidates::create([
                'candidate_id' => $data['candidate']->id,
                'accumulative' => $data['accumulative'],
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Top 5 candidates saved with accumulative scores successfully!'
        );
    }
}
