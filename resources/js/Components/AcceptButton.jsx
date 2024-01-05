import React from "react";

export default function AcceptButton({onClick, size = 24, color = "#ffffff", className}) {

    return (
        <button
            onClick={onClick}
            className={"text-white hidden bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300" +
                " font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-green-600" +
                " dark:hover:bg-green-700 dark:focus:ring-blue-800 " + className}
        >
            <svg fill="#ffffff" height={size} width={size} version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 490 490" xml:space="preserve">
<polygon points="452.253,28.326 197.831,394.674 29.044,256.875 0,292.469 207.253,461.674 490,54.528 "/>
</svg>

        </button>
    )
}
