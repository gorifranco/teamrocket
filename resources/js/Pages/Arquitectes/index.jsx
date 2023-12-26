import React from "react";
import {Head, useForm} from "@inertiajs/react";
import Authenticated from "@/Layouts/AuthenticatedLayout.jsx";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";

export function index (auth){
    const {data, setData, post, processing, reset, errors} = useForm({
        nom: '',
        descripcio: ''
    })

    function submit(evt)
    {
        evt.preventDefault()
        post(route('arquitectes.store'), {onSuccess: ()=> reset()});
    }
    return(
            <Authenticated auth={auth}>
                <Head title={"Arquitectes"}/>
                <form className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-xs" onSubmit={submit}>
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="nom">
                            Nom
                        </label>
                        <input
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="nom" type="text" placeholder="Nom" name={"nom"} required={true}
                            value={data.nom}
                            onChange={e => setData('nom', e.target.value)}/>
                        <InputError message={errors.nom}/>
                    </div>
                    <div className="mb-6">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                            Descripció
                        </label>
                        <textarea
                            className="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            name={"descripcio"} id="descripcio" rows={4} placeholder="Descripció" required={true}
                            value={data.descripcio}
                            onChange={e => setData('descripcio', e.target.value)}/>
                        <InputError message={errors.descripcio}/>
                    </div>
                    <div className="flex items-center justify-center">
                        <PrimaryButton
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Crear Arquitecte
                        </PrimaryButton>
                    </div>
                </form>
            </Authenticated>
    )
}
