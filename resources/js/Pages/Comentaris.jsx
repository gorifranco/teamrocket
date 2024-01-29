import SelectGori from "@/Components/selects/SelectGori.jsx";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import TableGori from "@/Components/TableGori.jsx";
import {useEffect, useState} from "react";
import axios from "axios";

export default function Comentaris({auth}){
    const [espais, setEspais] = useState({});
    const [currentEspai, setCurrentEspai] = useState(0)

    if(auth.tipusUsuari !== "usuari"){
        useEffect(() => {
            fetchEspais()
        }, []);
    }

    async function fetchEspais(){
        try {
            const response = await axios.get(`/api/espais_per_gestor_tots`, {
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                },
            });
            setEspais(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    }

    function changeEspai(espai) {
        if(espai){
            setCurrentEspai(espai.id)
            setFormData({
                ...formData,
                fk_espai: espai.id
            })
        }else{
            setCurrentEspai(0)
        }
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Comentaris</h2>}
            plusButton={false}
        >
            {auth.user.tipusUsuari !== "usuari" && (
                <div className="flex justify-center items-center my-5">
                    <span className="mr-6 font-medium">Visita:</span>
                    <SelectGori options={espais} className={"min-w-60"} onChange={changeEspai}></SelectGori>
                </div>
            )}

        </AuthenticatedLayout>
    )
}

