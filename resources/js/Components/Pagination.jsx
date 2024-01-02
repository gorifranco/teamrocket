import React from 'react';
import {Link} from "@inertiajs/react";

export default function Pagination(links) {

    return (
        links.links !== undefined && links.links.length > 0 && (
            <div className="mb-4">
                <div className="flex flex-wrap mt-8">
                    {links.links.map((link, index) => {
                        if (link.active) {
                            return (<div
                                key={index}
                            className={"mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded focus:border-primary focus:text-primary"}>
                                {link.label}
                            </div>)
                        }else{
                            return (
                                <Link
                                    key={index}
                                className="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-blue-500 focus:border-primary focus:text-primary bg-blue-700 text-white"
                                href={link.url}
                            >
                                {link.label}
                            </Link>)
                        }
                    })}
                </div>
            </div>
        )
    )
}
