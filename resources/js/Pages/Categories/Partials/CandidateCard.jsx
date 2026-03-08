"use client";

import React, { useState } from "react";
import ScoreInput from "./ScoreInput";

const CandidateCard = ({ candidate, index, onScoreChange, maxScore = 100 }) => {
    const [score, setScore] = useState(candidate.score || "");

    const defaultImage = "/candidates/linear.jfif";
    const genderFolder = candidate.gender.toLowerCase();
    const imageSrc = candidate.profile_img
        ? candidate.profile_img
        : `/candidates/${genderFolder}/${genderFolder}_${index + 1}.jpg`;

    const handleScoreChange = (val) => {
        setScore(val);
        if (onScoreChange) onScoreChange(candidate.id, val);
    };

    return (
        <div className="bg-neutral-900 border border-white/20 rounded-xl p-4 shadow-[0_4px_15px_rgba(255,255,255,0.3)] hover:shadow-[0_6px_25px_rgba(255,255,255,0.5)] transition-shadow duration-300 flex flex-col items-center gap-3">
            <img
                src={imageSrc || defaultImage}
                alt={`${candidate.first_name} ${candidate.last_name}`}
                className="w-full h-64 object-cover rounded-md"
            />

            <div className="text-center">
                <h3 className="font-bold text-white">
                    {candidate.first_name} {candidate.last_name}
                </h3>
                {candidate.course && (
                    <p className="text-sm text-gray-300 mt-1 capitalize">
                        {candidate.course}
                    </p>
                )}
            </div>

            <ScoreInput
                value={score}
                onChange={handleScoreChange}
                max={maxScore}
            />
        </div>
    );
};

export default CandidateCard;
