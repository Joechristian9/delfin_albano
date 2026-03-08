<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $femaleCandidates = [
            ['Elsie', 'Valdez'],
            ['Nicole Kim', 'Paguirigan'],
            ['Andrea Leigh', 'Fernandez',],
            ['Kenneth Clier', 'Bunagan',],
            ['Ma. Kathleen Joyce', 'Cabanlong',]
        ];

        foreach ($femaleCandidates as $index => $candidate) {
            Candidate::create([
                'first_name'      => $candidate[0],
                'last_name'       => $candidate[1],
                'profile_img'     => "candidates/female/" . ($index + 1) . ".jpg",
                'candidate_number' => $index + 1,
            ]);
        }
    }
}
