import {Head, Link} from "@inertiajs/react";
import axios from "axios";
import {useEffect, useState} from "react";

export default function Espai({auth}) {

    const [data, setData] = useState()
    const urlActual = window.location.href.split("/");
    const id = urlActual[urlActual.length - 1];


    useEffect(() => {
        fetchData();
    }, []);

    async function fetchData () {
        try {
            const response = await axios.get(`/api/espais/`+ id,{
                headers: {
                    'Authorization': `Bearer ${auth.user.api_token}`,
                },
            });
            setData(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    }


    return (
        <>
            <Head title="Welcome"/>
            <div className="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
                {auth.user ? (
                    <Link
                        href={route('dashboard')}
                        className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >
                        Dashboard
                    </Link>
                ) : (
                    <>
                        <Link
                            href={route('login')}
                            className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >
                            Log in
                        </Link>

                        <Link
                            href={route('register')}
                            className="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >
                            Register
                        </Link>
                    </>
                )}
            </div>

                {data !== undefined && (
                    <div className={"w-1/2 mx-auto mt-5"}>
                    <a href={"/"} className={"bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"}
                    >
                        Tornar
                    </a>
                    <h1 className={"text-3xl text-center mb-4"}>{data.nom}</h1>
                    <p className={"text-center"}>{data.descripcio}</p>

                        <div className={"mt-6 flex justify-center"}><div className={"bg-amber-100"} style={{ height: '450px', width: '450px' }}>IMATGE</div></div>

                        <div style={{height:"1000px"}}></div>
                    </div>

                )}
            {data !== undefined && (
            <aside className={"sticky bottom-[25%] h-3/4 w-1/4 float-right bg-amber-300"}>Uep com va</aside>
                )}
        </>
    )
}
