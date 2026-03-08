"use client";

import React from "react";
import PageLayout from "@/Layouts/PageLayout";
import TopFiveSelectionTable from "@/Pages/Admin/Partials/TopFiveSelectionTable";

const TotalResults = ({ categoryName = "Total Results", candidates = [] }) => {
    return (
        <PageLayout>
            <h2 className="text-white text-xl font-bold mb-6 justify-center flex mt-6">
                {categoryName}
            </h2>

            <TopFiveSelectionTable
                candidates={candidates}
                categories={[
                    "accumulative",
                    "top_five_beauty_of_face",
                    "top_five_beauty_of_body",
                    "top_five_posture_and_carriage_confidence",
                    "top_five_final_q_and_a",
                ]}
                category={`${categoryName} Results`}
            />
        </PageLayout>
    );
};

export default TotalResults;
