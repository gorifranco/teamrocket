import DeleteButton from "@/Components/DeleteButton.jsx";
import EditButton from "@/Components/EditButton.jsx";
import InputTable from "@/Components/InputTable.jsx";
import AcceptButton from "@/Components/AcceptButton.jsx";
import DenyButton from "@/Components/DenyButton.jsx";
import {useState} from "react";

export default function TableGori({
                                      value,
                                      data,
                                      cols,
                                      onClickEdit,
                                      onClickDelete,
                                      onClickAcceptButton,
                                      onClickDenyButton,
                                      className = '',
                                      children,
                                      ...props
                                  }) {

    const [editing, setEditing] = useState(false)
    const [rowEditing , setRowEditing] = useState(-1)
    const [editedValues, setEditedValues] = useState({});

    function handleEdit(evt, index, rowData) {
        evt.preventDefault();
        setEditing(true);
        setRowEditing(index);
        setEditedValues(rowData);
    }

    function handleAccept(evt, index) {
        evt.preventDefault();
        if (confirm("segur que vols canviar la fila " + index + "?")) {
            setEditing(false);
            setRowEditing(-1);
        } else {
        }
    }
        function handleDeny(){
        setEditing(false)
        setRowEditing(-1)
    }

    const handleChange = (evt, columnName) => {
        const { value } = evt.target;
        setEditedValues({
            ...editedValues,
            [columnName]: value,
        });
    };

    function handleDelete(evt) {
        //Torna s'id
        onClickDelete(evt.target.parentElement.parentElement.firstChild.firstChild.data)
    }

    return (
        <div className="flex flex-col">
            <div className="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                <div className="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div className="overflow-hidden">
                        <table className="min-w-full">
                            <thead className="bg-white border-b">
                            <tr key={"th"}>
                                <th scope="col" className="text-lg font-bold text-gray-900 px-9 py-4 text-center"
                                    key={"th#"}>#
                                </th>
                                {cols.map((val) => (
                                    <th scope="col"
                                        className="text-lg font-medium text-gray-900 px-9 py-4 text-left capitalize"
                                        key={"th" + val}>
                                        {val}
                                    </th>
                                ))}
                                <th scope="col"
                                    className="text-lg font-medium text-gray-900 px-9 py-4 text-center capitalize"
                                    key={"thacc"}>
                                    accions
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            {Object.entries(data.data).map(([key, value], index) => (
                                <tr
                                    className={`border-b ${index % 2 === 0 ? 'bg-gray-100' : 'bg-white'}`}
                                    key={"tr" + index}>
                                    <td className="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center"
                                        key={"td1" + key + value + index}>
                                        {value["id"]}
                                    </td>

                                    <td className="text-sm text-gray-900 font-light px-9 py-3 whitespace-nowrap"
                                        key={"td2" + key + value + index}>

                                        <InputTable type={"text"}
                                                    value={rowEditing === index ? editedValues[cols[0]] || value[cols[0]] : value[cols[0]]}
                                                    disabled={rowEditing !== index}
                                                    key={"td3_input" + key + value + index}/>

                                    </td>
                                    <td className="text-sm text-gray-900 font-light px-6 py-3 whitespace-nowrap"
                                        key={"td3" + key + value + index}>

                                        <InputTable type={"date"}
                                                    value={rowEditing === index ? editedValues[cols[1]] || value[cols[1]] : value[cols[1]]}
                                                    disabled={rowEditing !== index}
                                                    key={"td3_input" + key + value + index}/>

                                    </td>
                                    <td className="text-sm text-gray-900 font-light px-9 py-3 whitespace-nowrap"
                                        key={"td4" + key + value + index}>

                                        <InputTable type={"text"}
                                                    value={rowEditing === index ? editedValues[cols[2]] || value[cols[2]] : value[cols[2]]}
                                                    disabled={rowEditing !== index}
                                                    key={"td3_input" + key + value + index}/>
                                    </td>
                                    <td className="text-sm text-gray-900 font-light px-6 py-3 whitespace-nowrap justify-center flex">

                                        {rowEditing !== index && (
                                            <>
                                                <EditButton onClick={(evt) => handleEdit(evt, index, value)} />
                                                <DeleteButton onClick={handleDelete} />
                                            </>
                                        )}

                                        {editing && rowEditing === index && (
                                            <>
                                                <AcceptButton onClick={(evt) => handleAccept(evt, index)} />
                                                <DenyButton onClick={(evt) => handleDeny(evt, index)} />
                                            </>
                                        )}

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
