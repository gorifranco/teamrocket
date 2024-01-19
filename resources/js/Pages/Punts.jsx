import {useEffect, useState} from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import axios from "axios";
import SelectGori from "@/Components/selects/SelectGori.jsx";
import TableGori from "@/Components/TableGori.jsx";
import Form from "@/Components/Form.jsx";
import InputError from "@/Components/InputError.jsx";

export default function Punts({auth}){
    const [formCrearVisible, setFormHidden] = useState(false)
    const [successMessage, setSuccessMessage] = useState(false);
    const [data, setData] = useState();
    const [espais, setEspais] = useState({});
    const [formData, setFormData] = useState({})
    const cols = {
        nom: 'text',
        espai: 'text',
        descripcio: 'textArea'
    }

    const [errors, setErrors] = useState({
        nom: '',
        descripcio: ''
    });


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

    function handleChange(e) {
        const {name, value} = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    }

    function handleSubmit(e){
        e.preventDefault()

        axios.post('/api/punts_interes', formData, {
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            },
        })
            .then(() => {
                setFormData({
                    ...formData,
                    nom: '',
                    descripcio: ''
                });

                setErrors({
                    nom: '',
                    descripcio: ''
                })
                setSuccessMessage(true);
                fetchData()
            })
            .catch(function (error) {
                if (error.response) {
                    setErrors(error.response.data.errors);
                    console.log(error); // Acceder a los errores de validación
                    alert(error.request.statusText)
                } else {

                    console.log('Error:', error.message);
                }
            });
    }

    function changeEspai(espai) {
        setFormData({
            ...formData,
            fk_espai: espai.id,
        });
    }

    function handleDelete(punt) {
        console.log(punt)
        if (confirm("Segur que vols borrar el punt d'interés " + punt + "?")) {
            axios.delete("api/punts_interes/" + punt, {
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                },
            })
                .then(() => {
                    alert("Punt d'interés borrat amb èxit")
                    fetchData()
                })
                .catch(() => {
                    alert("El punt d'interés no s'ha pogut borrar")
                })
        }
    }

    function handleEdit(dades) {

        axios.put("api/punts_interes/" + dades.id, dades, {
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            },
        })
            .then(response => {
                alert("Punt d'interes guardat amb èxit")
                fetchData()
            }).catch((e) => {
            alert("Error guardant el punt d'interés:\n" +
                e)
        })
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
                <SelectGori options={espais} className={"min-w-60"} onChange={changeEspai}></SelectGori>
            </div>

            {formCrearVisible &&
                (<Form handleSubmit={handleSubmit} titol={"Crear un punt d'interés"} className={"mt-5"}>
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="nom">
                            Nom
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="nom" type="text" placeholder="Nom" name={"nom"} required={true}
                            value={formData.nom}
                            onChange={handleChange}/>
                        <InputError message={(errors !== undefined) ? errors.nom : ""}/>
                    </div>
                    <div className="mb-6 mt-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                            Descripció
                        </label>
                        <textarea
                            className="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            name={"descripcio"} id="descripcio" rows={4} placeholder="Descripció" required={true}
                            value={formData.descripcio}
                            onChange={handleChange}/>
                        <InputError message={(errors !== undefined) ? errors.descripcio : ""}/>
                    </div>
                    <div className="flex items-center justify-center">
                    </div>

                    {successMessage && (
                        <div
                            className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 font-medium"
                            role="alert">
                            Arquitecte creat!
                        </div>
                    )}
                </Form>)
            }
            <TableGori data={data} cols={cols} onClickDelete={handleDelete} onEdit={handleEdit}>
            </TableGori>

        </AuthenticatedLayout>
    )
}
