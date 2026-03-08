<?php

namespace App\Http\Controllers\ResultController;

use App\Http\Controllers\Controller;
use App\Services\TopFiveService;
use Inertia\Inertia;

class TopFiveCandidateResultController extends Controller
{
    protected $service;

    public function __construct(TopFiveService $service)
    {
        $this->service = $service;
    }

    /**
     * BEAUTY OF FACE RESULTS
     */
    public function beautyOfFaceResults()
    {
        $results = $this->service->getResultsPerCategory('top_five_beauty_of_face');

        return Inertia::render('Admin/TopFiveCategories/BeautyOfFaceResult', [
            'candidates'   => $results['candidates'],
            'judgeOrder'   => $results['judgeOrder'],
            'categoryName' => 'Beauty of Face',
        ]);
    }

    /**
     * BEAUTY OF BODY RESULTS
     */
    public function beautyOfBodyResults()
    {
        $results = $this->service->getResultsPerCategory('top_five_beauty_of_body');

        return Inertia::render('Admin/TopFiveCategories/BeautyOfBodyResult', [
            'candidates'   => $results['candidates'],
            'judgeOrder'   => $results['judgeOrder'],
            'categoryName' => 'Beauty of Body',
        ]);
    }

    /**
     * POSTURE AND CARRIAGE RESULTS
     */
    public function postureAndCarriageConfidenceResults()
    {
        $results = $this->service->getResultsPerCategory('top_five_posture_and_carriage_confidence');

        return Inertia::render('Admin/TopFiveCategories/PostureAndCarriageResult', [
            'candidates'   => $results['candidates'],
            'judgeOrder'   => $results['judgeOrder'],
            'categoryName' => 'Posture and Carriage / Confidence',
        ]);
    }

    /**
     * FINAL Q & A RESULTS
     */
    public function finalQAResults()
    {
        $results = $this->service->getResultsPerCategory('top_five_final_q_and_a');

        return Inertia::render('Admin/TopFiveCategories/FinalQAResult', [
            'candidates'   => $results['candidates'],
            'judgeOrder'   => $results['judgeOrder'],
            'categoryName' => 'Final Q & A',
        ]);
    }

    /**
     * TOTAL COMBINED RESULTS
     */
    public function totalResults()
    {
        $results = $this->service->getTotalResults();

        return Inertia::render('Admin/TopFiveCategories/TotalResults', [
            'candidates'   => $results['candidates'],
            'judgeOrder'   => $results['judgeOrder'],
            'categoryName' => 'Total Combined Scores',
        ]);
    }
}
