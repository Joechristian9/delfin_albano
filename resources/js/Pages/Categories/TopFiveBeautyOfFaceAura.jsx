"use client";

import React, { useRef, useState } from "react";
import { router, usePage } from "@inertiajs/react";
import PageLayout from "@/Layouts/PageLayout";
import CandidateGrid from "./Partials/CandidateGrid";
import ScoreAlertDialog from "./Partials/ScoreAlertDialog";
import { toast } from "sonner";

const BeautyOfFaceAura = ({ candidates }) => {
    const judgeId = usePage().props.auth.user.id;
    const scoresRef = useRef({});

    const [_, setRerender] = useState(0);
    const [submitted, setSubmitted] = useState(false);

    const handleScoreChange = (candidateId, score) => {
        scoresRef.current = { ...scoresRef.current, [candidateId]: score };
        setRerender((r) => r + 1);
    };

    const allScoresFilled = candidates.every(
        (c) =>
            scoresRef.current[c.id] !== undefined &&
            scoresRef.current[c.id] !== "",
    );

    const handleSubmit = () => {
        const filteredScores = Object.fromEntries(
            candidates
                .map((c) => [c.id, scoresRef.current[c.id]])
                .filter(([_, score]) => score !== undefined && score !== ""),
        );

        if (!judgeId) {
            alert("Judge ID is missing!");
            return;
        }

        if (Object.keys(filteredScores).length !== candidates.length) {
            alert("Please fill in all scores before submitting!");
            return;
        }

        router.post(
            route("beauty_of_face_aura.store"),
            {
                judge_id: judgeId,
                scores: filteredScores,
            },
            {
                onSuccess: () => {
                    toast.success("Scores submitted successfully!");
                    router.reload();
                    setSubmitted(true);
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
                <h2 className="text-2xl font-bold text-neutral-200 mb-6">
                    Beauty of Face / Aura
                </h2>

                <CandidateGrid
                    candidates={candidates}
                    maxScore={15}
                    scoresRef={scoresRef}
                    onScoreChange={handleScoreChange}
                    submitted={submitted}
                />

                <ScoreAlertDialog
                    candidates={candidates}
                    scoresRef={scoresRef}
                    allScoresFilled={allScoresFilled}
                    handleSubmit={handleSubmit}
                    submitted={submitted}
                />
            </div>
        </PageLayout>
    );
};

export default BeautyOfFaceAura;
