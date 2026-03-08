"use client";

import React, { useRef, useState } from "react";
import { router, usePage } from "@inertiajs/react";
import PageLayout from "@/Layouts/PageLayout";
import CandidateGrid from "./Partials/CandidateGrid";
import ScoreAlertDialog from "../Partials/ScoreAlertDialog";
import { toast } from "sonner";

const TopFiveBeautyOfFace = ({ candidates }) => {
    const judgeId = usePage().props.auth.user.id;
    const scoresRef = useRef({});
    const [submitted, setSubmitted] = useState(false);
    const [_, setRerender] = useState(0);

    const handleScoreChange = (candidateId, score) => {
        scoresRef.current[candidateId] = score;
        setRerender((r) => r + 1);
    };

    const allScoresFilled = candidates.every(
        (c) =>
            scoresRef.current[c.candidate_id] !== undefined &&
            scoresRef.current[c.candidate_id] !== "",
    );

    const handleSubmit = () => {
        const filteredScores = Object.fromEntries(
            candidates.map((c) => [
                c.candidate_id,
                scoresRef.current[c.candidate_id] ?? c.existing_score ?? 0,
            ]),
        );

        if (!judgeId) {
            alert("Judge ID is missing!");
            return;
        }

        if (Object.values(filteredScores).some((s) => s === "")) {
            alert("Please fill in all scores before submitting!");
            return;
        }

        router.post(
            route("beauty_of_face.store"),
            {
                judge_id: judgeId,
                scores: filteredScores,
            },
            {
                onSuccess: () => {
                    toast.success("Scores submitted successfully!");
                    setSubmitted(true);
                    router.reload();
                },
                onError: () => {
                    toast.error("Failed to submit scores.");
                },
            },
        );
    };

    return (
        <PageLayout>
            <div className="w-full my-10 px-4 flex flex-col items-center gap-6">
                <div className="text-center">
                    <h2 className="text-2xl font-bold text-neutral-200 text-center mb-6">
                        Beauty of Face
                    </h2>
                </div>

                <CandidateGrid
                    candidates={candidates}
                    maxScore={15}
                    scoresRef={scoresRef}
                    onScoreChange={handleScoreChange}
                    submitted={submitted}
                    categoryField="beauty_of_face"
                />

                <ScoreAlertDialog
                    candidates={candidates}
                    scoresRef={scoresRef}
                    allScoresFilled={allScoresFilled}
                    handleSubmit={handleSubmit}
                    submitted={submitted}
                    categoryField="beauty_of_face"
                />
            </div>
        </PageLayout>
    );
};

export default TopFiveBeautyOfFace;
