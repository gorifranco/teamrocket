import Pagination from "@/Components/Pagination.jsx";

export default function TableGori({value, data, cols, className = '', children, ...props}) {

    return (
        <div className="flex flex-col">
            <div className="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                <div className="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div className="overflow-hidden">
                        <table className="min-w-full">
                            <thead className="bg-white border-b">
                            <tr key={"th"}>
                                <th scope="col" className="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                                    key={"th#"}>#
                                </th>
                                {cols.map((val) => (
                                    <th scope="col" className="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                                        key={"th" + val}>
                                        {val}
                                    </th>
                                ))}
                            </tr>
                            </thead>
                            <tbody>

                            {Object.entries(data.data).map(([key, value], index) => (
                                <tr
                                    className={`border-b ${index % 2 === 0 ? 'bg-gray-100' : 'bg-white'}`}
                                    key={"tr" + index}>
                                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                        key={"td1" + key + value + index}>{value["id"]}</td>
                                    <td className="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                        key={"td2" + key + value + index}>
                                        {(value[cols[0]] !== null) ? value[cols[0]] : ""}
                                    </td>
                                    <td className="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                        key={"td3" + key + value + index}>
                                        {value[cols[1]]}
                                    </td>
                                    <td className="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                        key={"td4" + key + value + index}>
                                        {value[cols[2]]}
                                    </td>
                                </tr>
                            ))
                            }
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    );
}
