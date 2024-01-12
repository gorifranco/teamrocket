import React from "react";

export default function MenosButton({onClick, size = 24, color = "#ffffff", className}) {

    return (
        <button
            onClick={onClick}
            type={"button"}
            className={"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300" +
                " font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600" +
                " dark:hover:bg-blue-700 dark:focus:ring-blue-800 " + className}
        >
            <svg xmlns="http://www.w3.org/2000/svg" width={24} height={24} viewBox="0 0 24 24" fill="none"
                 stroke={color} strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
        </button>
    )
}
