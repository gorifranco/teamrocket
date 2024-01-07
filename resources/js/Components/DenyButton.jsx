import React from "react";

export default function DenyButton({onClick, size = 24, color = "#ffffff", className, ...props}) {

    return (
        <button
            {...props}
            onClick={onClick}
            className={"text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300" +
                " font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600" +
                " dark:hover:bg-red-700 dark:focus:ring-blue-800 " + className}
        >
            <svg fill="#ffffff" height={size} width={size} version="1.1" id="Capa_1"
                 xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 490 490" xmlSpace="preserve">
<polygon points="456.851,0 245,212.564 33.149,0 0.708,32.337 212.669,245.004 0.708,457.678 33.149,490 245,277.443 456.851,490
	489.292,457.678 277.331,245.004 489.292,32.337 "/>
</svg>
        </button>
    )
}
