import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {useEffect, useState} from "react";
import axios from "axios";
import { DataGrid } from '@mui/x-data-grid';

export default function Comentaris({auth}){
    const [espais, setEspais] = useState({});
    const [currentEspai, setCurrentEspai] = useState(0)
    const columns = [
        { field: 'id', headerName: 'ID', width: 70 },
        { field: 'firstName', headerName: 'First name', width: 130 },
        { field: 'lastName', headerName: 'Last name', width: 130 },
        {
            field: 'age',
            headerName: 'Age',
            type: 'number',
            width: 90,
        },
    ]

    const rows = [
        { id: 1, lastName: 'Snow', firstName: 'Jon', age: 35 },
        { id: 2, lastName: 'Lannister', firstName: 'Cersei', age: 42 },
        { id: 3, lastName: 'Lannister', firstName: 'Jaime', age: 45 },
        { id: 4, lastName: 'Stark', firstName: 'Arya', age: 16 },
    ]

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
<div className={"max-w-[600px] flex justify-center mx-auto"}>
    <DataGrid
        rows={rows}
        columns={columns}
        initialState={{
            pagination: {
                paginationModel: { page: 0, pageSize: 5 },
            },
        }}
        pageSizeOptions={[5, 10]}
    />
</div>


        </AuthenticatedLayout>
    )
}

