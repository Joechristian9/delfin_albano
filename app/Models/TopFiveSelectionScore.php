<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopFiveSelectionScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'judge_id',
        'creative_attire',
        'casual_wear',
        'swim_wear',
        'filipiniana_attire',
        'beauty_of_face_aura',
        'beauty_of_body',
        'posture_and_carriage_confidence',
        'total_score',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
}
