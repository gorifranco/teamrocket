import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {useEffect, useState} from "react";
import axios from "axios";
import InputError from "@/Components/InputError.jsx";
import MunicipisSelect from "@/Components/selects/SelectMunicipis.jsx";
import PlusButton from "@/Components/PlusButton.jsx";
import MenosButton from "@/Components/MenosButton.jsx";
import TipusEspaiSelect from "@/Components/selects/SelectTipusEspai.jsx";
import GrauAccesSelect from "@/Components/selects/SelectGrauAccessibilitat.jsx";
import Form from "@/Components/Form.jsx";
import ArquitectesSelect from "@/Components/selects/SelectArquitectes.jsx";
import ModalitatsSelect from "@/Components/selects/SelectModalitats.jsx";

export default function Espai_edit({auth}){

    const [successMessage, setSuccessMessage] = useState(false)
    const urlActual = window.location.href.split("/");
    const id = urlActual[urlActual.length - 1];

    const [data, setData] = useState({})
    const [numeroArquitectes, setNumeroArquitectes] = useState(0)
    const [numeroModalitats, setNumeroModalitats] = useState(0)

    const [errors, setErrors] = useState({
        nom: '',
        email: '',
        descripcio: '',
        direccio: '',
        web: '',
        telefon: '',
        any_construccio: '',
        grau_accessibilitat: '',
        fk_tipusEspai: '',
        fk_municipi: '',
        modalitats: [],
        arquitectes: [],
    });

    function handleChange(e){
        const {name, value} = e.target;

        if (!name.includes(" ")) {
            setData({
                ...data,
                [name]: value,
            });
        } else {
            let [fieldName, index] = name.split(" ");
            index = parseInt(index, 10);

            setData((prevData) => {
                const newArrayField = [...prevData[fieldName]];
                newArrayField[index] = value;

                return {
                    ...prevData,
                    [fieldName]: newArrayField,
                };
            });
        }
    }

    function arquitectes() {
        let arq = [];

        for (let i = 0; i < numeroArquitectes; i++) {
            arq.push(<ArquitectesSelect key={"arq" + i} selected={(data.arquitectes[i])?data.arquitectes[i]:-1} className={"mt-2"} name={"arquitectes " + i}
                                        onChange={handleChange}></ArquitectesSelect>)
        }
        return arq;
    }

    function modalitats() {
        let mod = [];

        for (let i = 0; i < numeroModalitats; i++) {
            mod.push(<ModalitatsSelect name={"modalitats " + i} selected={(data.modalitats[i])?data.modalitats[i]:-1} key={"mod" + i} className={"mt-2"}
                                       onChange={handleChange}></ModalitatsSelect>)
        }
        return mod;
    }


    function afegirArquitecte() {
        setNumeroArquitectes(numeroArquitectes + 1)
    }

    function llevarArquitecte() {
        setNumeroArquitectes(numeroArquitectes - 1)
        const newArquitectes = [...data.arquitectes];
        newArquitectes.pop();
        setData(prevData => ({
            ...prevData,
            arquitectes: newArquitectes,
        }));
    }

    function afegirModalitat() {
        setNumeroModalitats(numeroModalitats + 1)
    }

    function llevarModalitat() {
        setNumeroModalitats(numeroModalitats - 1)
        const newModalitats = [...data.modalitats];
        newModalitats.pop();
        setData(prevData => ({
            ...prevData,
            modalitats: newModalitats,
        }));
    }

    const fetchData = async () => {
        try {
            const response = await axios.get(`/api/espais/` + id);
    console.log(response.data.data)
            const modalitatsIds = response.data.data.modalitats.map(modalitat => modalitat.id);
            const arquitectesIds = response.data.data.arquitectes.map(arquitecte => arquitecte.id);

            setData({
                nom: response.data.data.nom,
                email: response.data.data.email,
                descripcio: response.data.data.descripcio,
                direccio: response.data.data.direccio,
                web: response.data.data.web,
                telefon: response.data.data.telefon,
                any_construccio: response.data.data.any_construccio,
                grau_accessibilitat: response.data.data.grau_accessibilitat,
                fk_tipusEspai: response.data.data.fk_tipusEspai,
                fk_municipi: response.data.data.municipi.id,
                modalitats: modalitatsIds,
                arquitectes: arquitectesIds,
            });
            setNumeroModalitats(response.data.data.modalitats.length)
            setNumeroArquitectes(response.data.data.arquitectes.length)

            if (response.data.data.fk_gestor && response.data.data.fk_gestor !== auth.user.id) {
                window.location.href = route("espais_per_gestor");
            }
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    };

    useEffect(() => {
        fetchData();
    }, []);


    function handleSubmit(event) {
        event.preventDefault()

        axios.put('/api/espais/' + id, data, {
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            },
        })
            .then(() => {
                setErrors({
                    nom: '',
                    email: '',
                    descripcio: '',
                    direccio: '',
                    web: '',
                    telefon: '',
                    any_construccio: '',
                    grau_accessibilitat: '',
                    fk_tipusEspai: '',
                    fk_municipi: '',
                    modalitats: [],
                    arquitectes: [],
                })
                setSuccessMessage(true);
                fetchData()
            })
            .catch(function (error) {
                if (error.response) {
                    setErrors(error.response.data.data);
                    console.log(error.data); // Acceder a los errores de validación
                    alert(error.request.statusText)
                } else {
                    console.log('Error:', error.message);
                }
            });
    }


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Editar l'espai</h2>}
            plusButton={false}
        >
            <div>
                <a href={route("espais_per_gestor")} className="absolute top-[22%] left-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                >Torna</a>
            </div>

            <Form handleSubmit={handleSubmit} titol={"Crear un espai"} className={"mt-5"} tag={"Editar"}>
                <div className="mb-4">
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="nom">
                        Nom
                    </label>
                    <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="nom" type="text" placeholder="Nom" name={"nom"} required={true}
                        value={data.nom}
                        onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.nom : ""}/>
                </div>
                <div>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="desc">
                        Descripció
                    </label>
                    <textarea rows={7}
                              className={"block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"}
                              placeholder={"Descripció"}
                              required={true}
                              onChange={handleChange}
                              name={"descripcio"}
                              value={data.descripcio}
                    >
                        </textarea>
                    <InputError message={(errors !== undefined) ? errors.descripcio : ""}/>
                </div>

                <div className={"mt-4"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="direccio">
                        Direcció
                    </label>
                    <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="direccio" type="text" placeholder="Direcció" name={"direccio"} required={true}
                        value={data.direccio}
                        onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.direccio : ""}/>
                </div>

                <div className={"mt-4"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="telefon">
                        Telèfon
                    </label>
                    <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="telefon" type="tel" placeholder="Telèfon" name={"telefon"} required={true}
                        value={data.telefon}
                        onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.telefon : ""}/>
                </div>

                <div className={"mt-4"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="email">
                        Email
                    </label>
                    <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="tel" placeholder="Email" name={"email"} required={true}
                        value={data.email}
                        onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.email : ""}/>
                </div>

                <div className={"mt-4"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="any">
                        Any de construcció
                    </label>
                    <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="any" type="number" placeholder="Any de construcció" name={"any_construccio"}
                        required={true}
                        value={data.any_construccio}
                        onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.any_construccio : ""}/>
                </div>

                <div className={"mt-4"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="web">
                        Web
                    </label>
                    <input
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="web" type="text" placeholder="Web" name={"web"} required={true}
                        value={data.web}
                        onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.web : ""}/>
                </div>

                <div className={"mt-4"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"municipi"}>
                        Municipi
                    </label>
                    <MunicipisSelect selected={(data)?data.fk_municipi:-1} onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.fk_municipi : ""}/>
                </div>

                <div className={"mt-4"} key={"divx"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"arquitecte"}>
                        Arquitectes
                    </label>
                    <>
                        {arquitectes()}
                    </>
                    <div className={"flex"}>
                        <PlusButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"}
                                    onClick={afegirArquitecte}></PlusButton>
                        {numeroArquitectes > 1 && (
                            <MenosButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"}
                                         onClick={llevarArquitecte}></MenosButton>
                        )}
                        <InputError message={(errors !== undefined) ? errors.arquitectes : ""}/>
                    </div>
                </div>

                <div className={"mt-4"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"modalitats"}>
                        Modalitats
                    </label>
                    <>
                        {modalitats()}
                    </>
                    <div className={"flex"}>
                        <PlusButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"}
                                    onClick={afegirModalitat}></PlusButton>
                        {numeroModalitats > 1 && (
                            <MenosButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"}
                                         onClick={llevarModalitat}></MenosButton>
                        )}
                        <InputError message={(errors !== undefined) ? errors.modalitats : ""}/>
                    </div>
                </div>

                <div className={"mt-4"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"tipus"}>
                        Tipus d'espai
                    </label>
                    <TipusEspaiSelect selected={(data)?data.fk_tipusEspai:-1} onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.fk_tipusEspai : ""}/>
                </div>

                <div className={"mt-4 mb-6"}>
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"grau_acces"}>
                        Grau d'accessibilitat
                    </label>
                    <GrauAccesSelect selected={(data)?data.grau_accessibilitat:""} onChange={handleChange}/>
                    <InputError message={(errors !== undefined) ? errors.grau_accessibilitat : ""}/>
                </div>

                <div className="flex items-center justify-center">
                </div>

                {successMessage && (
                    <div
                        className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 font-medium"
                        role="alert">
                        Espai editat!
                    </div>
                )}
            </Form>
        </AuthenticatedLayout>
    )
}
