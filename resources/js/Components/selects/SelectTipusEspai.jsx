import {useEffect, useState} from "react";
import axios from "axios";

export default function TipusEspaiSelect({id = "tipus"}){

    const [valors, setValors] = useState([])

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const response = await axios.get(`/api/tipus_espais_tots`);
            setValors(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    };

    return (
        <>
            <select id={id} className={"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"}>
                <option key={-1} value={""}>Tipus d'espai</option>
                {valors.map((tipus) => (
                    <option key={tipus.id} value={tipus.id}>
                        {tipus.nom}
                    </option>
                ))}
            </select>
        </>
    )
}
