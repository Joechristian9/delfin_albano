"use client";

import React, { useState } from "react";
import { motion } from "motion/react";
import { cn } from "@/lib/utils";

export function HoverGradientInput({
    value,
    onChange,
    placeholder = "0.00",
    containerClassName = "",
    inputClassName = "",
    ...props
}) {
    const [focused, setFocused] = useState(false);

    return (
        <div
            className={cn(
                "relative rounded-full p-px w-28 h-12",
                containerClassName
            )}
            onMouseEnter={() => setFocused(true)}
            onMouseLeave={() => setFocused(false)}
        >
            {/* Rotating gradient using backgroundPosition */}
            <motion.div
                className="absolute inset-0 rounded-full"
                style={{
                    background:
                        "linear-gradient(270deg, #3275F8, #F83377, #3275F8, #F83377)",
                    backgroundSize: "600% 600%",
                    filter: "blur(5px)",
                }}
                animate={{ backgroundPosition: ["0% 50%", "100% 50%"] }}
                transition={{ repeat: Infinity, ease: "linear", duration: 6 }}
            />

            {/* Focus highlight */}
            {focused && (
                <div
                    className="absolute inset-0 rounded-full pointer-events-none"
                    style={{
                        background:
                            "radial-gradient(75% 181% at 50% 50%, #3275F8 0%, rgba(50,117,248,0) 100%)",
                        filter: "blur(4px)",
                    }}
                />
            )}

            {/* Input */}
            <input
                type="number"
                min="0"
                max="100"
                step="0.01"
                value={value}
                onChange={onChange}
                onFocus={() => setFocused(true)}
                onBlur={() => setFocused(false)}
                placeholder={placeholder}
                className={cn(
                    "relative z-10 w-full text-center px-4 py-2 rounded-full bg-neutral-900 text-white focus:outline-none focus:bg-neutral-800",
                    inputClassName
                )}
                {...props}
            />
        </div>
    );
}
