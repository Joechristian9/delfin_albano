"use client";

import React from "react";
import PageLayout from "@/Layouts/PageLayout";
import ResultTable from "@/Pages/Admin/Partials/ResultTable";

const BeautyOfBodyResult = ({
    categoryName = "Beauty of Body",
    candidates = [],
    judgeOrder = [],
}) => {
    return (
        <PageLayout>
            <h2 className="text-white text-xl font-bold mb-6 flex justify-center mt-6">
                {categoryName} Results (15 Points)
            </h2>

            <ResultTable
                candidates={candidates}
                judgeOrder={judgeOrder}
                category="beauty_of_body"
            />
        </PageLayout>
    );
};

export default BeautyOfBodyResult;
