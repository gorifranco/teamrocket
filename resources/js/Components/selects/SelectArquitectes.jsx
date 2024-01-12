import {useEffect, useState} from "react";
import axios from "axios";

export default function ArquitectesSelect({id, className}){

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
            <select id={id} className={"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 " +
                "focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" +
                " dark:focus:ring-blue-500 dark:focus:border-blue-500 " + className}>
                <option key={-1} value={""}>Selecciona un arquitecte</option>
                {valors.map((arquitecte) => (
                    <option key={arquitecte.id} value={arquitecte.id}>
                        {arquitecte.nom}
                    </option>
                ))}
            </select>
        </>
    )
}
