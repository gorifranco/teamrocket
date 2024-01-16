import axios from "axios";
import {useState} from "react";

export default function EspaiDisplay({data}) {

    return (
        <div className={"my-5"}>
            <h2 className={"flex justify-center mb-6 text-2xl"}>{data.nom}</h2>
            <div className={"grid grid-cols-2 gap-10"}>
                <div className={"text-center"}>{data.descripcio}
                    <div className={"flex justify-center mt-5"}>
                        <a
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                            href={route("espai", {id: data.id})}>
                            ANAR
                        </a>
                    </div>
                </div>
                <div className={"bg-amber-100 text-center"}> FOTO</div>
            </div>
        </div>
    )
}
