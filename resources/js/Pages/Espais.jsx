import {Head} from "@inertiajs/react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from "@/Components/InputError.jsx";
import axios from 'axios';
import {useEffect, useState} from "react";
import Form from "@/Components/Form.jsx";
import TableGori from "@/Components/TableGori.jsx";
import Pagination from "@/Components/Pagination.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import ArquitectesSelect from "@/Components/selects/SelectArquitectes.jsx";
import TipusEspaiSelect from "@/Components/selects/SelectTipusEspai.jsx";
import PlusButton from "@/Components/PlusButton.jsx";
import MenosButton from "@/Components/MenosButton.jsx";
import ModalitatsSelect from "@/Components/selects/SelectModalitats.jsx";
import GrauAccesSelect from "@/Components/selects/SelectGrauAccessibilitat.jsx";
import MunicipisSelect from "@/Components/selects/SelectMunicipis.jsx";

export default function index({auth}) {
    const [currentPage, setCurrentPage] = useState(1);
    const [formCrearVisible, setFormHidden] = useState(false)
    const [formData, setFormData] =
        useState({
            nom: '',
            descripcio: '',
            direccio: '',
            web: '',
            telefon: '',
            any_construccio: '',
            grau_accessibilitat: '',
            tipusEspai: '',
            municipi: '',
            modalitats: [],
            arquitectes: [],
        });

    const [cercadorValue, setCercadorValue] = useState("")
    const cols = {
        activat: 'boolean',
        nom: 'text',
        descripcio: 'text',
        web: "text",
    }

    const [errors, setErrors] = useState({
        nom: '',
        descripcio: '',
        direccio: '',
        web: '',
        telefon: '',
        any_construccio: '',
        grau_accessibilitat: '',
        tipusEspai: '',
        municipi: '',
        modalitats: [],
        arquitectes: [],
    });

    const [tableData, setTableData] = useState({
            data: [{
                activat: '',
                nom: '',
                descripcio: '',
                web: "",
            }]
        }
    )

    const [successMessage, setSuccessMessage] = useState(false)
    const [numeroArquitectes, setNumeroArquitectes] = useState(1)
    const [numeroModalitats, setNumeroModalitats] = useState(1)

    function afegirArquitecte(){
        setNumeroArquitectes(numeroArquitectes + 1)
    }

    function llevarArquitecte(){
        setNumeroArquitectes(numeroArquitectes - 1)
    }

    function afegirModalitat(){
        setNumeroModalitats(numeroModalitats + 1)
    }

    function llevarModalitat(){
        setNumeroModalitats(numeroModalitats - 1)
    }

    function arquitectes(){
        let arq =[];

        for (let i = 0; i < numeroArquitectes; i++) {
            arq.push(<ArquitectesSelect key={"arq" + i} className={"mt-2"} name={"arquitectes " + i} onChange={handleChange}></ArquitectesSelect>)
        }
        return arq;
    }

    function modalitats(){
        let mod =[];

        for (let i = 0; i < numeroModalitats; i++) {
            mod.push(<ModalitatsSelect name={"modalitats " + i} key={"mod" + i} className={"mt-2"} onChange={handleChange}></ModalitatsSelect>)
        }
        return mod;
    }


    //Guardat del formulari
    async function handleSubmit(event) {
        event.preventDefault()

        axios.post('/api/espais', formData,{
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            },
        })
            .then(() => {
                setNumeroArquitectes(1)
                setNumeroModalitats(1)
                setFormData({
                    nom: '',
                    descripcio: '',
                    direccio: '',
                    web: '',
                    telefon: '',
                    any_construccio: '',
                    grau_accessibilitat: '',
                    tipusEspai: '',
                    municipi: '',
                    modalitats: [],
                    arquitectes: [],
                });

                setErrors({
                    nom: '',
                    descripcio: '',
                    direccio: '',
                    web: '',
                    telefon: '',
                    any_construccio: '',
                    grau_acces: '',
                    tipusEspai: '',
                    municipi: '',
                    modalitats: [],
                    arquitectes: [],
                })
                setSuccessMessage(true);
                fetchData(currentPage)
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

    function handleEdit($id){

        //ruta al formulari

    }

    function handleChange(e) {
        const { name, value } = e.target;

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
        console.log(formData)
    }


    const fetchData = async (currentPage) => {
        try {
            const response = await axios.get(`/api/espais_per_gestor?page=${currentPage}`, {
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                },
            });

            setTableData(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }

    };

    const fetchDataFiltrada = async (currentPage, filter) => {
        try {
            const response = await axios.get(`/api/espais_per_gestor/find/${filter}?page=${currentPage}`,{
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                },
            });
            setTableData(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    };

    useEffect(() => {
        fetchData(currentPage);
    }, [currentPage]);

    function handlePageChange(page) {
        setCurrentPage(page);
    }

    function obrirFormCrear() {
        if (formCrearVisible) setSuccessMessage(false)
        setFormHidden(!formCrearVisible)
    }

    function cercadorChange(e) {
        setCercadorValue(e.target.value)
    }

    function cercadorClick() {
        setCurrentPage(0)
        if (cercadorValue === "") {
            fetchData(currentPage)
        } else {
            fetchDataFiltrada(currentPage, cercadorValue)
        }
    }

    function handleDelete(espai) {
        if (confirm("Segur que vols borrar l'espai " + espai + "?")) {
            axios.delete("api/espais/" + espai,{
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                },
            })
                .then(() => {
                    alert("Espai borrat amb èxit")
                    fetchData(currentPage)
                })
                .catch(() => {
                    alert("L'espai no s'ha pogut borrar")
                })
        }
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Els meus espais</h2>}
            plusButton={true}
            onclickPlusButton={obrirFormCrear}
        >
            <Head title="Els meus espais"/>
            {formCrearVisible &&
                (<Form handleSubmit={handleSubmit} titol={"Crear un espai"} className={"mt-5"}>
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="nom">
                            Nom
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="nom" type="text" placeholder="Nom" name={"nom"} required={true}
                            value={formData.nom}
                            onChange={handleChange}/>
                        <InputError message={(errors !== undefined)?errors.nom:""}/>
                    </div>
                    <div>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="desc">
                            Descripció
                        </label>
                        <textarea rows={7} className={"block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"}
                        placeholder={"Descripció"}
                                  required={true}
                                  onChange={handleChange}
                                  name={"descripcio"}
                        >
                        </textarea>
                        <InputError message={(errors !== undefined)?errors.descripcio:""}/>
                    </div>

                    <div className={"mt-4"}>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="direccio">
                            Direcció
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="direccio" type="text" placeholder="Direcció" name={"direccio"} required={true}
                            value={formData.direccio}
                            onChange={handleChange}/>
                        <InputError message={(errors !== undefined)?errors.direccio:""}/>
                    </div>

                    <div className={"mt-4"}>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="telefon">
                            Telèfon
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="telefon" type="tel" placeholder="Telèfon" name={"telefon"} required={true}
                            value={formData.telefon}
                            onChange={handleChange}/>
                        <InputError message={(errors !== undefined)?errors.telefon:""}/>
                    </div>

                    <div className={"mt-4"}>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="any">
                            Any de construcció
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="any" type="number" placeholder="Any de construcció" name={"any_construccio"} required={true}
                            value={formData.any_construccio}
                            onChange={handleChange}/>
                        <InputError message={(errors !== undefined)?errors.any_construccio:""}/>
                    </div>

                    <div className={"mt-4"}>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="web">
                            Web
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="web" type="text" placeholder="Web" name={"web"} required={true}
                            value={formData.web}
                            onChange={handleChange}/>
                        <InputError message={(errors !== undefined)?errors.web:""}/>
                    </div>

                    <div className={"mt-4"}>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"municipi"}>
                            Municipi
                        </label>
                        <MunicipisSelect onChange={handleChange}/>
                        <InputError message={(errors !== undefined)?errors.municipi:""}/>
                    </div>

                    <div className={"mt-4"} key={"divx"}>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"arquitecte"}>
                            Arquitectes
                        </label>
                        <>
                            {arquitectes()}
                        </>
                        <div className={"flex"}>
                            <PlusButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"} onClick={afegirArquitecte}></PlusButton>
                            {numeroArquitectes>1 && (
                                <MenosButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"} onClick={llevarArquitecte}></MenosButton>
                            )}
                            <InputError message={(errors !== undefined)?errors.arquitectes:""}/>
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
                            <PlusButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"} onClick={afegirModalitat}></PlusButton>
                            {numeroModalitats>1 && (
                                <MenosButton className={"mt-2 bg-gray-400 hover:bg-gray-500"} color={"#222222"} onClick={llevarModalitat}></MenosButton>
                            )}
                            <InputError message={(errors !== undefined)?errors.modalitats:""}/>
                        </div>
                    </div>

                    <div className={"mt-4"}>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"tipus"}>
                            Tipus d'espai
                        </label>
                        <TipusEspaiSelect onChange={handleChange}/>
                        <InputError message={(errors !== undefined)?errors.tipusEspai:""}/>
                    </div>

                    <div className={"mt-4 mb-6"}>
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor={"grau_acces"}>
                            Grau d'accessibilitat
                        </label>
                        <GrauAccesSelect onChange={handleChange}/>
                        <InputError message={(errors !== undefined)?errors.grau_accessibilitat:""}/>
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
            <div className={"flex justify-center mt-2"}>
                <InputLabel>
                    <TextInput placeholder={"Cercador"} className={"border"} value={cercadorValue}
                               onChange={cercadorChange}/>
                </InputLabel>
                <PrimaryButton className={"ml-4"} onClick={cercadorClick}>
                    Cercar
                </PrimaryButton>
            </div>
            <TableGori data={tableData} cols={cols} onClickDelete={handleDelete} onEdit={handleEdit}>
            </TableGori>
            <Pagination
                links={tableData.links}
                onPageChange={handlePageChange}>
            </Pagination>
        </AuthenticatedLayout>
    )
}
