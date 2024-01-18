import {useEffect, useState} from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import axios from "axios";

export default function Punts({auth}){
    const [formCrearVisible, setFormHidden] = useState(false)
    const [successMessage, setSuccessMessage] = useState(false);
    const [data, setData] = useState();
    function obrirFormCrear() {
        if (formCrearVisible) setSuccessMessage(false)
        setFormHidden(!formCrearVisible)
    }

    useEffect(() => {
        fetchData();
    }, []);

    async function fetchData () {
        try {
            const response = await axios.get(`/api/punts/`+ id);
            setData(response.data.data);
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


        </AuthenticatedLayout>
    )
}
