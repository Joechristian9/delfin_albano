"use client";

import React from "react";
import PageLayout from "@/Layouts/PageLayout";
import ResultTable from "@/Pages/Admin/Partials/ResultTable";

const FinalQAResult = ({
    categoryName = "Question & Answer",
    candidates = [],
    judgeOrder = [],
}) => {
    return (
        <PageLayout>
            <h2 className="text-white text-xl font-bold mb-6 flex justify-center mt-6">
                {categoryName} Results
            </h2>

            <ResultTable
                candidates={candidates}
                judgeOrder={judgeOrder}
                category={`${categoryName} Results`}
            />
        </PageLayout>
    );
};

export default FinalQAResult;
