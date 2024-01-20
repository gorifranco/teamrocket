import {useEffect, useState} from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import axios from "axios";
import SelectGori from "@/Components/selects/SelectGori.jsx";
import TableGori from "@/Components/TableGori.jsx";
import Form from "@/Components/Form.jsx";
import InputError from "@/Components/InputError.jsx";

export default function Visites({auth}){
    const [formCrearVisible, setFormHidden] = useState(false)
    const [successMessage, setSuccessMessage] = useState(false);
    const [data, setData] = useState({});
    const [espais, setEspais] = useState({});
    const [formData, setFormData] = useState({
        nom: '',
        descripcio: '',
        dataInici: '',
        dataFi: '',
        reqInscripcio: '',
        preu: '',
        places: '',
    })
    const [currentEspai, setCurrentEspai] = useState(0)
    const cols = {
        nom: 'text',
        descripcio: 'textArea',
        dataInici: "date",
        dataFi: "date",
    }

    const [errors, setErrors] = useState({
        nom: '',
        descripcio: '',
        dataInici: '',
        dataFi: '',
        reqInscripcio: '',
        preu: '',
        places: '',
    });


    function obrirFormCrear() {
        if (formCrearVisible) setSuccessMessage(false)
        setFormHidden(!formCrearVisible)
    }

    useEffect(() => {
        fetchEspais()
    }, []);

    useEffect(() => {
        fetchData()
    }, [currentEspai]);


    async function fetchData () {
        try {
            const response = await axios.get(`/api/visites_per_espai/` + currentEspai);
            setData(response.data);
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

        axios.post('/api/visites', formData, {
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


    function handleDelete(visita) {
        if (confirm("Segur que vols borrar la visita " + visita + "?")) {
            axios.delete("api/visites/" + visita, {
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                },
            })
                .then(() => {
                    alert("Visita borrada amb èxit")
                    fetchData()
                })
                .catch(() => {
                    alert("La visita no s'ha pogut borrar")
                })
        }
    }

    function handleEdit(dades) {

        axios.put("api/visites/" + dades.id, dades, {
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            },
        })
            .then(response => {
                alert("Visita guardada amb èxit")
                fetchData()
            }).catch((e) => {
            alert("Error guardant la visita:\n" +
                e)
        })
    }


    return(
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Visites</h2>}
            plusButton={currentEspai>0}
            onclickPlusButton={obrirFormCrear}
        >

            <div className="flex justify-center items-center my-5">
                <span className="mr-6 font-medium">Visita:</span>
                <SelectGori options={espais} className={"min-w-60"} onChange={changeEspai}></SelectGori>
            </div>

            {formCrearVisible && currentEspai > 0 &&
                (<Form handleSubmit={handleSubmit} titol={"Crear una visita"} className={"mt-5"}>
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
                    <div className="mb-2 mt-4">
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
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="dataInici">
                        Data d'inici
                    </label>
                    <div className="max-w-sm relative">
                        <div className="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg className="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input type="date"
                               className="mt-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 pl-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Select date" name={"dataInici"}
                               value={formData.dataInici}
                               onChange={handleChange}/>
                        <InputError message={(errors !== undefined) ? errors.dataInici : ""}/>
                    </div>

                    <label className="block text-gray-700 text-sm font-bold mb-2 mt-4" htmlFor="dataFi">
                        Data de fi
                    </label>
                    <div className="max-w-sm relative">
                        <div className="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg className="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input type="date"
                               className="mt-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 pl-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Select date" name={"dataFi"}
                               value={formData.dataFi}
                               onChange={handleChange}/>
                        <InputError message={(errors !== undefined) ? errors.dataFi : ""}/>
                    </div>

                    <div className="mb-2 mt-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                            Requereix inscripció
                        </label>
                        <div className={"flex"}>
                        <input
                            className="shadow appearance-none border border-red-500 rounded py-2 px-2 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            name={"descripcio"} id="descripcio" type={"checkbox"}
                            value={formData.reqInscripcio}
                            onChange={handleChange}/>
                        <p className={"ml-2"}>Si</p>
                        </div>
                        <InputError message={(errors !== undefined) ? errors.reqInscripcio : ""}/>
                    </div>


                    {successMessage && (
                        <div
                            className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 font-medium"
                            role="alert">
                            Visita creada
                        </div>
                    )}
                </Form>)
            }
            <TableGori data={data} cols={cols} onClickDelete={handleDelete} onEdit={handleEdit}>
            </TableGori>

        </AuthenticatedLayout>
    )
}
