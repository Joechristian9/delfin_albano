"use client";

import React from "react";
import { router } from "@inertiajs/react";
import PageLayout from "@/Layouts/PageLayout";
import TopFiveSelectionTable from "./Partials/TopFiveSelectionTable";
import { HoverBorderGradient } from "@/Components/ui/hover-border-gradient";
import { toast } from "sonner";

const TopFiveSelectionResult = ({
    categoryName,
    candidates = [],
    categories,
}) => {
    const handleSetTopFive = () => {
        const top5Ids = [...candidates]
            .sort((a, b) => {
                if (a.rank !== b.rank) return a.rank - b.rank;
                return b.total - a.total;
            })
            .slice(0, 5)
            .map((c) => c.candidate.id);

        if (top5Ids.length !== 5) {
            toast.error("There must be exactly 5 top-ranked candidates.");
            return;
        }

        const loadingToastId = toast.loading("Saving Top 5...");

        router.post(
            route("topFive.set"),
            { candidate_ids: top5Ids },
            {
                preserveScroll: true,
                onSuccess: () => {
                    toast.dismiss(loadingToastId);
                    toast.success("Top 5 saved successfully!");
                },
                onError: () => {
                    toast.dismiss(loadingToastId);
                    toast.error("Failed to save Top 5.");
                },
            },
        );
    };

    return (
        <PageLayout>
            <h2 className="text-white text-xl font-bold mb-4 justify-center flex mt-6">
                {categoryName}
            </h2>

            <TopFiveSelectionTable
                candidates={candidates}
                categories={categories}
                category={categoryName}
            />

            <div className="flex justify-center mb-10">
                <HoverBorderGradient
                    containerClassName="rounded-full"
                    as="button"
                    className="dark:bg-neutral-800 bg-white text-black dark:text-neutral-100 flex items-center space-x-2 px-12 py-1 text-lg font-semibold"
                    onClick={handleSetTopFive}
                >
                    <span>Set Top 5</span>
                </HoverBorderGradient>
            </div>
        </PageLayout>
    );
};

export default TopFiveSelectionResult;
