import {useEffect, useState} from "react";
import axios from "axios";

export default function GrauAccesSelect({id = "grau_acces"}){

    return (
        <>
            <select id={id} className={"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"}>
                <option key={-1} value={""}>Grau d'accessibilitat</option>
                <option key={1} value={"baix"}>Baix</option>
                <option key={2} value={"mitj"}>Mitj</option>
                <option key={3} value={"alt"}>Alt</option>
            </select>
        </>
    )
}
