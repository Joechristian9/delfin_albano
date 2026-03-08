<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopFiveScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'top_five_id',
        'judge_id',
        'top_five_beauty_of_face',
        'top_five_beauty_of_body',
        'top_five_posture_and_carriage_confidence',
        'top_five_final_q_and_a',
        'total_score',
    ];

    public function topFive()
    {
        return $this->belongsTo(TopFiveCandidates::class, 'top_five_id');
    }

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
}
