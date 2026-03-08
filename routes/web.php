<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ResultController\TopFiveSelectionResultController;
use App\Http\Controllers\ResultController\TopFiveCandidateResultController;
use App\Http\Controllers\TopFiveSelectionScoreController;
use App\Http\Controllers\TopFiveCandidateController;
use App\Http\Controllers\TopFiveScoreController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Categories Routes
Route::middleware('auth')->group(function () {
    Route::get('/creative-attire', [CandidateController::class, 'creative_attire'])
        ->name('creative_attire');

    Route::get('/casual-wear', [CandidateController::class, 'casual_wear'])
        ->name('casual_wear');

    Route::get('/swim-wear', [CandidateController::class, 'swim_wear'])
        ->name('swim_wear');

    Route::get('/filipiniana-attire', [CandidateController::class, 'filipiniana_attire'])
        ->name('filipiniana_attire');

    Route::get('/beauty-of-face-aura', [CandidateController::class, 'beauty_of_face_aura'])
        ->name('beauty_of_face_aura');

    Route::get('/beauty-of-body', [CandidateController::class, 'beauty_of_body'])
        ->name('beauty_of_body');

    Route::get('/posture-and-carriage-confidence', [CandidateController::class, 'posture_and_carriage_confidence'])
        ->name('posture_and_carriage_confidence');
});


Route::middleware('auth')->group(function () {
    Route::post('/creative-attire/scores', [TopFiveSelectionScoreController::class, 'creative_attire_store'])
        ->name('creative_attire.store');

    Route::post('/casual-wear/scores', [TopFiveSelectionScoreController::class, 'casual_wear_store'])
        ->name('casual_wear.store');

    Route::post('/swim-wear/scores', [TopFiveSelectionScoreController::class, 'swim_wear_store'])
        ->name('swim_wear.store');

    Route::post('/filipiniana-attire/scores', [TopFiveSelectionScoreController::class, 'filipiniana_attire_store'])
        ->name('filipiniana_attire.store');

    Route::post('/beauty-of-face-aura/scores', [TopFiveSelectionScoreController::class, 'beauty_of_face_aura_store'])
        ->name('beauty_of_face_aura.store');

    Route::post('/beauty-of-body/scores', [TopFiveSelectionScoreController::class, 'beauty_of_body_store'])
        ->name('beauty_of_body.store');

    Route::post('/posture-and-carriage-confidence/scores', [TopFiveSelectionScoreController::class, 'posture_and_carriage_confidence_store'])
        ->name('posture_and_carriage_confidence.store');
});


// Admin Results Routes (Top 5 Selection)
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/admin/creative-attire', [TopFiveSelectionResultController::class, 'creativeAttireResults'])
        ->name('admin.creative_attire');

    Route::get('/admin/casual-wear', [TopFiveSelectionResultController::class, 'casualWearResults'])
        ->name('admin.casual_wear');

    Route::get('/admin/swim-wear', [TopFiveSelectionResultController::class, 'swimWearResults'])
        ->name('admin.swim_wear');

    Route::get('/admin/filipiniana-attire', [TopFiveSelectionResultController::class, 'filipinianaAttireResults'])
        ->name('admin.filipiniana_attire');

    Route::get('/admin/beauty-of-face-aura', [TopFiveSelectionResultController::class, 'beautyOfFaceAuraResults'])
        ->name('admin.top5_beauty_face');

    Route::get('/admin/beauty-of-body', [TopFiveSelectionResultController::class, 'beautyOfBodyResults'])
        ->name('admin.top5_beauty_body');

    Route::get('/admin/posture-and-carriage-confidence', [TopFiveSelectionResultController::class, 'postureAndCarriageConfidenceResults'])
        ->name('admin.top5_posture_confidence');

    // Top Five summary
    Route::get('/admin/top-five-selection', [TopFiveSelectionResultController::class, 'topFiveSelectionResults'])
        ->name('admin.top_five_selection');
});



// Category Routes (Top 5 Finalists)
Route::middleware('auth')->group(function () {

    // Display Routes
    Route::get('/beauty_of_face', [TopFiveCandidateController::class, 'beautyOfFace'])
        ->name('beauty_of_face');

    Route::get('/beauty_of_body_final_final', [TopFiveCandidateController::class, 'beautyOfBody'])
        ->name('beauty_of_body_final');

    Route::get('/posture_and_carriage_confidence_final', [TopFiveCandidateController::class, 'postureAndCarriageConfidence'])
        ->name('posture_and_carriage_confidence_final');

    Route::get('/q_and_a', [TopFiveCandidateController::class, 'qAndA'])
        ->name('q_and_a');

    Route::get('/final_q_and_a', [TopFiveCandidateController::class, 'final_q_and_a'])
        ->name('final_q_and_a');

    // Store Routes
    Route::post('/beauty-of-face/store', [TopFiveScoreController::class, 'beautyOfFaceStore'])
        ->name('beauty_of_face.store');

    Route::post('/beauty-of-body/store', [TopFiveScoreController::class, 'beautyOfBodyStore'])
        ->name('beauty_of_body_final.store');

    Route::post('/posture-and-carriage-confidence_final/store', [TopFiveScoreController::class, 'postureAndCarriageConfidenceStore'])
        ->name('posture_and_carriage_confidence_final.store');

    Route::post('/q-and-a/store', [TopFiveScoreController::class, 'qAndAStore'])
        ->name('q_and_a.store');

    Route::post('/final-q-and-a/store', [TopFiveScoreController::class, 'finalQAStore'])
        ->name('final_q_and_a.store');
});

// Admin Set Top 5 Candidates Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/top-five', [TopFiveSelectionResultController::class, 'setTopFive'])
        ->name('topFive.set');
});

// Admin Top 5 Candidates Result Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get(
        '/admin/final_q_and_a/results',
        [TopFiveCandidateResultController::class, 'finalQAResults']
    )->name('admin.final_q_and_a');

    Route::get(
        '/admin/beauty_of_face/results',
        [TopFiveCandidateResultController::class, 'beautyOfFaceResults']
    )->name('admin.beauty_of_face');

    Route::get(
        '/admin/beauty_of_body/results',
        [TopFiveCandidateResultController::class, 'beautyOfBodyResults']
    )->name('admin.beauty_of_body_final');

    Route::get(
        '/admin/posture_and_carriage_confidence/results',
        [TopFiveCandidateResultController::class, 'postureAndCarriageConfidenceResults']
    )->name('admin.posture_and_carriage_confidence_final');

    Route::get(
        '/admin/q_and_a/results',
        [TopFiveCandidateResultController::class, 'finalQAResults']
    )->name('admin.q_and_a');

    Route::get(
        '/admin/total_results',
        [TopFiveCandidateResultController::class, 'totalResults']
    )->name('admin.top_five_finalist');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
