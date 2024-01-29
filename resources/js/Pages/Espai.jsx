import {Head, Link} from "@inertiajs/react";
import axios from "axios";
import {useEffect, useState} from "react";
import ReactStars from "react-rating-stars-component/dist/react-stars.js";

export default function Espai({auth}) {

    const [data, setData] = useState()
    const urlActual = window.location.href.split("/");
    const id = urlActual[urlActual.length - 1];
    const [comentari, setComentari] = useState('')
    const [valoracio, setValoracio] = useState(0)


    useEffect(() => {
        fetchData();
    }, []);

    async function fetchData () {
        try {
            const response = await axios.get(`/api/espais/`+ id);
            setData(response.data.data);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    }

    function handleChange(e){
        setComentari(e.target.value)
    }

    function ratingChange(e){
        setValoracio(e)
    }

    function handleSubmit(e){
        e.preventDefault()
        console.log(id)

        axios.post("/api/comentaris", {
            comentari: comentari,
            valoracio: valoracio,
            fk_espai: id
        }, {
            headers: {
                'Authorization': `Bearer ${auth.user.api_token}`,
            },
        })
            .then(r => alert("Comentari enviat. Esperant verificació"))
            .catch(e => alert(e))
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

                        <div className={"mt-6 flex justify-center"}>
                                <img src={data.imatge.url} alt={"imatge principal"}/>
                        </div>

                    </div>

                )}

            <div className={"mt-10 mb-4 text-xl text-center justify-center flex mx-auto"}>
                COMENTARIS
            </div>

            {auth.user ? (
                <div className="text-center flex flex-col items-center mx-auto">
                    <ReactStars
                        count={5}
                        onChange={ratingChange}
                        size={24}
                        isHalf={false}
                        activeColor="#ffd700"
                    />
                    <form className="text-center" onSubmit={handleSubmit}>
                        <div className="mb-2">
                            <textarea onChange={handleChange} className="min-w-[400px]" placeholder="Escribe tu comentario"></textarea>
                        </div>
                        <div>
                            <input type="submit" value="Comentar" className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" />
                        </div>
                    </form>
                </div>
            ) : (
                <div className={"mt-10 text-center justify-center flex mx-auto"}>
                    (REGISTRA'T PER COMENTAR)
                </div>
            )}
            {data !== undefined && (
            data.comentaris.map(val => {
                <p>Comentari</p>
            })
                )}


        </>
    )
}
