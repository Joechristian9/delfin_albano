<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $femaleCandidates = [
            ['Khayla', 'Fernandez'],
            ['Lyka', 'Galam'],
            ['Jazlyn', 'Seguro'],
            ['Heart Angel', 'Visaya'],
            ['Heart Angel', 'Pillos'],
            ['Althea', 'Vinoya'],
            ['Precious Joy', 'Acido'],
            ['Mery Rose', 'Pintucan'],
            ['Vanessa', 'Tuazon'],
            ['Reighn', 'Carnate'],
            ['Sharah Mayne', 'Mendieta'],
            ['Thea May', 'Macalinao'],
            ['Hanna Jade', 'Balber'],
            ['Allysa', 'Cadiente'],
            ['Mhay Ann', 'Dumalag']
        ];

        foreach ($femaleCandidates as $index => $candidate) {
            Candidate::create([
                'first_name'       => $candidate[0],
                'last_name'        => $candidate[1],
                'profile_img'      => "candidates/" . ($index + 1) . ".jpg",
                'candidate_number' => $index + 1,
            ]);
        }
    }
}