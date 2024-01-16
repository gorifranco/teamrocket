import {Link, Head} from '@inertiajs/react';
import React from "react";
import {useEffect, useState} from "react";
import axios from "axios";
import EspaiDisplay from "@/Components/EspaiDisplay.jsx";

export default function Welcome({auth}) {

    const [posts, setPosts] = useState({})
    const [currentPage, setCurrentPage] = useState(1)

    const fetchData = async (currentPage) => {
        try {
            const response = await axios.get(`/api/espais`);
            setPosts(response.data.data);
            console.log(response.data)
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    };

    useEffect(() => {
        fetchData(currentPage);
    }, [currentPage]);


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

            <div className={"justify-center flex mx-auto my-5"}><h1 className={"text-3xl"}>TEAMROCKET</h1></div>

            <div className={"w-screen flex justify-center"}>
                <div className={"w-7/12"}>
                    {Object.values(posts).map((value) => (
                        <React.Fragment key={value.id}>
                            <EspaiDisplay data={value}></EspaiDisplay>
                            <hr className={"my-5"}/>
                        </React.Fragment>
                    ))}
                </div>
            </div>

        </>
    );
}
