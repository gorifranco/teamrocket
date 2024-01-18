import {useEffect, useState} from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import axios from "axios";
import SelectGori from "@/Components/selects/SelectGori.jsx";

export default function Punts({auth}){
    const [formCrearVisible, setFormHidden] = useState(false)
    const [successMessage, setSuccessMessage] = useState(false);
    const [data, setData] = useState();
    const [espais, setEspais] = useState({});

    function obrirFormCrear() {
        if (formCrearVisible) setSuccessMessage(false)
        setFormHidden(!formCrearVisible)
    }

    useEffect(() => {
        fetchEspais();
        // fetchData();
    }, []);

    async function fetchData () {
        try {
            const response = await axios.get(`/api/punts/`);
            setData(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
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

    return(
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Punts d'interés</h2>}
            plusButton={true}
            onclickPlusButton={obrirFormCrear}
        >
            <div className="flex justify-center items-center my-5">
                <span className="mr-6 font-medium">Espai:</span>
                <SelectGori options={espais} className={"min-w-60"}></SelectGori>
            </div>

        </AuthenticatedLayout>
    )
}
