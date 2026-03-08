"use client";

import React from "react";
import PageLayout from "@/Layouts/PageLayout";
import ResultTable from "@/Pages/Admin/Partials/ResultTable";

const PostureAndCarriageResult = ({
    categoryName = "Posture and Carriage / Confidence",
    candidates = [],
    judgeOrder = [],
}) => {
    return (
        <PageLayout>
            <h2 className="text-white text-xl font-bold mb-6 flex justify-center mt-6">
                {categoryName} Results (10 Points)
            </h2>

            <ResultTable
                candidates={candidates}
                judgeOrder={judgeOrder}
                category="posture_and_carriage_confidence"
            />
        </PageLayout>
    );
};

export default PostureAndCarriageResult;
