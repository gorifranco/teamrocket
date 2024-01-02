import React from 'react';

export default function Pagination({links, onPageChange}) {

    const handlePage = (evt) => {
            onPageChange(evt.target.id);
    };

function treureID(string){
    if(string !== null){
        let temp = string.split("=")
        return temp[temp.length-1];
    }
}
    return (

    links!== undefined && links.length > 0 && (
            <div className={"flex justify-center"}>
            <div className="mb-4">
                <div className="flex flex-wrap mt-8">
                    {links.map((link, index) => {
                        if (link.active || link.url == null) {
                            return (<div
                                key={index}
                            className={"mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded focus:border-primary focus:text-primary"}>
                                {link.label}
                            </div>)
                        }else{
                            return (
                                <button
                                    key={index}
                                className="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-blue-500 focus:border-primary focus:text-primary bg-blue-700 text-white"
                                    id={treureID(link.url)}
                                    onClick={handlePage}
                                >
                                {link.label}
                            </button>)
                        }
                    })}
                </div>
            </div>
            </div>
        )
    )
}
