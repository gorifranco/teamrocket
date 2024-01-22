import {useEffect, useState} from "react";
import axios from "axios";

export default function SelectPuntsInteres({id, className, espai = 0, key, name, onChange, selected = -1}) {

    const [valors, setValors] = useState([])

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const response = await axios.get(`/api/punts_per_espai/` + espai);
            setValors(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    };

    return (
        <>
            <select key={key} id={id}
                    className={"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 " +
                        "focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" +
                        " dark:focus:ring-blue-500 dark:focus:border-blue-500 " + className}
                    name={name}
                    onChange={onChange}>
                <option key={-1} value={""}>Selecciona un punt</option>
                {valors.map((punt) => (
                    <option key={punt.id} value={punt.id} selected={selected === punt.id}>
                        {punt.nom}
                    </option>
                ))}
            </select>
        </>
    )
}
