import {useEffect, useState} from "react";
import axios from "axios";

export default function ArquitectesSelect(){

    const [valors, setValors] = useState([])

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const response = await axios.get(`/api/arquitectes_all`);
            setValors(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    };

    return (
        <>
            <label htmlFor={"arquitectes"} className={"block mb-2 text-sm font-medium text-gray-900 dark:text-white"}>Tria l'arquitecte</label>
            <select id={"countries"} className={"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"}>
                {valors.map((arquitecte) => (
                    <option key={arquitecte.id} value={arquitecte.id}>
                        {arquitecte.nom}
                    </option>
                ))}
            </select>
        </>
    )
}
