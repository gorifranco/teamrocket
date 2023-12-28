import {Head} from "@inertiajs/react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import axios from 'axios';
import {useState} from "react";
export default function index ({auth}){
    const [formData, setFormData] = useState({
        nom: '',
        data_naix: '',
        descripcio: ''
    });


    const [errors, setErrors] = useState({
        nom: '',
        data_naix: '',
        descripcio: ''
    });

    const [successMessage, setSuccessMessage] = useState(false); // Estado para mostrar el mensaje de éxito



    const handleChange = (event) => {
        const { name, value } = event.target;
        setFormData(prevFormData => ({
            ...prevFormData,
            [name]: value
        }));
    };

    async function handleSubmit (event) {
        event.preventDefault()

        axios.post('/api/arquitectes', formData)
            .then(function (response) {
                setFormData({
                    nom: '',
                    data_naix: '',
                    descripcio: ''
                });

                setErrors({
                    nom: '',
                    data_naix: '',
                    descripcio: ''
                })
                setSuccessMessage(true);
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

    return(
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Arquitectes</h2>}
        >
            <Head title="Dashboard" />
            <div className={"flex flex-row min-h-screen justify-center items-center"}>
                <form className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-xs"
                      onSubmit={handleSubmit}>
                    <div className={"text-center font-bold"}>Crear Arquitecte</div>
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
                    <div className="relative max-w-sm">
                        <div className="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg className="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input type="date"
                               className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Select date" name={"data_naix"}
                               value={formData.data_naix}
                               onChange={handleChange}/>
                        <InputError message={errors.data_naix}/>
                    </div>
                    <div className="mb-6">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                            Descripció
                        </label>
                        <textarea
                            className="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            name={"descripcio"} id="descripcio" rows={4} placeholder="Descripció" required={true}
                            value={formData.descripcio}
                            onChange={handleChange}/>
                        <InputError message={errors.descripcio}/>
                    </div>
                    <div className="flex items-center justify-center">
                        <PrimaryButton
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Crear Arquitecte
                        </PrimaryButton>
                    </div>
                    {successMessage && (
                    <div
                        className="mt-6 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 font-medium"
                        role="alert">
                        Arquitecte creat!
                        again.
                    </div>
                    )}
                </form>
            </div>
        </AuthenticatedLayout>
    )
}
