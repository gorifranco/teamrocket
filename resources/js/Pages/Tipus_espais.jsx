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

export default function index({auth}) {
    const [currentPage, setCurrentPage] = useState(1);
    const [formCrearVisible, setFormHidden] = useState(false)
    const [formData, setFormData] = useState([]);
    const [cercadorValue, setCercadorValue] = useState("")
    const cols = {
        nom: 'text',
    }

    const [errors, setErrors] = useState({
        nom: '',
    });

    const [tableData, setTableData] = useState({
            data: [{
                nom: "",
            }]
        }
    )

    const [successMessage, setSuccessMessage] = useState(false);


    //Guardat del formulari
    async function handleSubmit(event) {
        event.preventDefault()

        axios.post('/api/tipus_espais', formData, {
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            }
        })
            .then(() => {
                setFormData({
                    nom: '',
                });

                setErrors({
                    nom: '',
                })
                setSuccessMessage(true);
                fetchData(currentPage)
            })
            .catch(function (error) {
                if (error.response) {
                    setErrors(error.response.data.errors);
                    console.log(error.response.data.errors); // Acceder a los errores de validación
                } else {
                    console.log('Error:', error.message);
                }
            });

    }

    function handleEdit(dades) {
        axios.put("api/tipus_espais/" + dades.id, dades, {
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            }
        })
            .then(response => {
                alert("Tipus d'espai guardat amb èxit")
                fetchData(currentPage)
            }).catch((e) => {
            alert("Error guardant el tipus d'espai:\n" +
                e)
        })
    }

    function handleChange(e) {
        const {name, value} = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    }


    const fetchData = async (currentPage) => {
        try {
            const response = await axios.get(`/api/tipus_espais?page=${currentPage}`, {
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                }
            });
            setTableData(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    };

    const fetchDataFiltrada = async (currentPage, filter) => {
        try {
            const response = await axios.get(`/api/tipus_espais/find/${filter}?page=${currentPage}`, {
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                }
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

    function handleDelete(tipusEspai) {
        if (confirm("Segur que vols borrar el tipus d'espai " + tipusEspai + "?")) {
            axios.delete("api/tipus_espais/" + tipusEspai, {
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                }
            })
                .then(() => {
                    alert("Tipus d'espai borrat amb èxit")
                    fetchData(currentPage)
                })
                .catch(() => {
                    alert("El tipus d'espai no s'ha pogut borrar")
                })
        }
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Tipus d'espais</h2>}
            plusButton={true}
            onclickPlusButton={obrirFormCrear}
        >
            <Head title="Modalitats"/>
            {formCrearVisible &&
                (<Form handleSubmit={handleSubmit} titol={"Crear un tipus d'espai"} className={"mt-5"}>
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="nom">
                            Nom
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="nom" type="text" placeholder="Nom" name={"nom"} required={true}
                            value={formData.nom}
                            onChange={handleChange}/>
                        <InputError message={errors.nom}/>
                    </div>
                    <div className="flex items-center justify-center">
                    </div>

                    {successMessage && (
                        <div
                            className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 font-medium"
                            role="alert">
                            Tipus d'espai creat!
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
            {tableData !== undefined && (
                <>
                    <TableGori data={tableData} cols={cols} onClickDelete={handleDelete} onEdit={handleEdit}>
                    </TableGori>
                    <Pagination
                        links={tableData.links}
                        onPageChange={handlePageChange}>
                    </Pagination>
                </>
            )}

        </AuthenticatedLayout>
    )
}
