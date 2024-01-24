import {useEffect, useState} from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import axios from "axios";
import Form from "@/Components/Form.jsx";
import InputError from "@/Components/InputError.jsx";
import PlusButton from "@/Components/PlusButton.jsx";
import MenosButton from "@/Components/MenosButton.jsx";
import SelectPuntsInteres from "@/Components/selects/SelectPuntsInteres.jsx";

export default function Visites({auth}){
    const [successMessage, setSuccessMessage] = useState(false);
    const urlActual = window.location.href.split("/");
    const id = urlActual[urlActual.length - 1];
    const [numeroPunts, setNumeroPunts] = useState(1)
    const [formData, setFormData] = useState({
        nom: '',
        descripcio: '',
        dataInici: '',
        dataFi: '',
        reqInscripcio: '',
        preu: 0,
        places: 0,
        puntsInteres: [],
    })

    const [errors, setErrors] = useState({
        nom: '',
        descripcio: '',
        dataInici: '',
        dataFi: '',
        reqInscripcio: '',
        preu: '',
        places: '',
        puntsInteres: ""
    });

    useEffect(() => {
        fetchData();
    }, []);

    async function fetchData() {
        try {
            const response = await axios.get(`/api/visites/` + id);
            console.log(response.data.data)
            const puntsIds = response.data.data.punts_interes.map(punt => punt.id);

            setFormData({
                nom: response.data.data.nom,
                descripcio: response.data.data.descripcio,
                dataInici: response.data.data.dataInici,
                dataFi: response.data.data.dataFi,
                reqInscripcio: response.data.data.reqInscripcio,
                preu: response.data.data.preu,
                places: response.data.data.places,
                fk_espai: response.data.data.fk_espai,
                puntsInteres: puntsIds,
            });
            setNumeroPunts(response.data.data.punts_interes.length)

            if (response.data.data.fk_gestor && response.data.data.fk_gestor !== auth.user.id) {
                window.location.href = route("dashboard");
            }
        } catch (error) {
            console.error('Error al obtener los datos:', error);
            throw error; // Lanzamos el error para que pueda ser capturado por el bloque catch en fetchDataAndPunts
        }
    }


    function handleChange(e) {
        const {name, value} = e.target;

        if (!name.includes(" ")) {
            setFormData({
                ...formData,
                [name]: value,
            });
        } else {
            let [fieldName, index] = name.split(" ");
            index = parseInt(index, 10);

            setFormData((prevFormData) => {
                const newArrayField = [...prevFormData[fieldName]];
                newArrayField[index] = value;

                return {
                    ...prevFormData,
                    [fieldName]: newArrayField,
                };
            });
        }
    }
    function handleChangeCheckbox(e){
        setFormData(({
            ...formData,
            reqInscripcio: e.target.checked
        }))
    }

    function handleSubmit(e){
        e.preventDefault()
        console.log(formData)

        axios.put('/api/visites/' + id, formData, {
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            },
        })
            .then(() => {
                setErrors({
                    nom: '',
                    descripcio: '',
                    dataInici: '',
                    dataFi: '',
                    reqInscripcio: '',
                    preu: '',
                    places: '',
                    puntsInteres: ""
                })
                setSuccessMessage(true);
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

    function afegirPunt() {
        setNumeroPunts(numeroPunts + 1)
    }

    function llevarPunt() {
        setNumeroPunts(numeroPunts - 1)
        const newPuntsInteres = [...formData.puntsInteres];
        newPuntsInteres.pop();
        setFormData(prevData => ({
            ...prevData,
            puntsInteres: newPuntsInteres,
        }));
    }

    function pintaPunts() {
        let p = [];

        for (let i = 0; i < numeroPunts; i++) {
            p.push(<div key={"d"+i} className={"flex items-center align-middle w-full" }>
                <p key={"p"+i} className={"mr-2 text-xl"}>{i+1}</p>
                <SelectPuntsInteres espai={formData.fk_espai} selected={(formData.puntsInteres[i])?formData.puntsInteres[i]:-1} name={"puntsInteres " + i} key={"punt" + i} className={"mt-2 w-full"}
                onChange={handleChange}></SelectPuntsInteres> </div>)
        }
        return p;
    }


    return(
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Editar visita</h2>}
            plusButton={false}
        >
            <div>
                <a href={route("visites")} className="absolute top-[22%] left-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                >Torna</a>
            </div>
                <Form tag={"Editar"} handleSubmit={handleSubmit} titol={"Edita una visita"} className={"mt-5"}>
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
                                checked={formData.reqInscripcio}
                                onChange={handleChangeCheckbox}/>
                            <p className={"ml-2"}>{(formData.reqInscripcio)?"SI":"NO"}</p>
                        </div>
                        <InputError message={(errors !== undefined) ? errors.reqInscripcio : ""}/>
                    </div>

                    <div className="mb-2 mt-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="preu">
                            Preu
                        </label>
                        <div className={"flex items-center align-middle w-full mb-3"}>
                            <input
                                className="shadow appearance-none border border-red-500 w-full rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name={"preu"} id="preu" placeholder="Preu" required={true}
                                type={"number"}
                                value={formData.preu}
                                onChange={handleChange}/>
                            <p className={"ml-2 text-xl"}>€</p>
                        </div>
                        <InputError message={(errors !== undefined) ? errors.preu : ""}/>
                    </div>

                    <div className="mb-2 mt-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="preu">
                            Places
                        </label>
                        <input
                            className="shadow appearance-none border border-red-500 mb-2 w-full rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            name={"places"} id="preu" placeholder="Places" required={true}
                            type={"number"}
                            value={formData.places}
                            onChange={handleChange}/>
                        <InputError message={(errors !== undefined) ? errors.places : ""}/>
                    </div>

                    <div className="mb-2 mt-4">
                        <div className={"mt-4"}>
                            <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"punts"}>
                                Punts d'interes per ordre
                            </label>
                            <>
                                {pintaPunts()}
                            </>
                            <div className={"flex"}>
                                <PlusButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"}
                                            onClick={afegirPunt}></PlusButton>
                                {numeroPunts > 1 && (
                                    <MenosButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"}
                                                 onClick={llevarPunt}></MenosButton>
                                )}
                                <InputError message={(errors !== undefined) ? errors.puntsInteres : ""}/>
                            </div>
                        </div>
                    </div>

                    {successMessage && (
                        <div
                            className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 font-medium"
                            role="alert">
                            Visita editada!
                        </div>
                    )}
                </Form>
        </AuthenticatedLayout>
    )
}