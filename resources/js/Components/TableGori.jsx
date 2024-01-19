import DeleteButton from "@/Components/DeleteButton.jsx";
import EditButton from "@/Components/EditButton.jsx";
import InputTable from "@/Components/InputTable.jsx";
import AcceptButton from "@/Components/AcceptButton.jsx";
import DenyButton from "@/Components/DenyButton.jsx";
import {useState} from "react";
import BasicHooksExample from "@/Components/SwitchGoriBo.jsx";

export default function TableGori({
                                      value,
                                      data,
                                      cols,
                                      onClickDelete,
                                      onEdit,
                                      className = '',
                                      children,
                                      handleSwitch,
                                      editUrl,
                                      ...props
                                  }) {

    const [editing, setEditing] = useState(false)
    const [rowEditing, setRowEditing] = useState(-1)
    const [editedValues, setEditedValues] = useState({});

    function handleEdit(evt, index, rowData) {
        console.log(rowData)
        evt.preventDefault();

        if(editUrl){
            window.location.href = route("editarEspai", {id: rowData.id})
        }else{
            setEditing(true);
            setRowEditing(index);
            setEditedValues(rowData);
        }
    }

    function handleAccept(evt, index) {
        evt.preventDefault();
        if (confirm("segur que vols canviar la fila " + index + "?")) {
            onEdit(editedValues)
            setEditing(false);
            setRowEditing(-1);
        }
    }

    function handleDeny() {
        setEditing(false)
        setRowEditing(-1)
    }

    const handleChange = (evt, columnName) => {
        const {value} = evt.target;
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
                                {Object.keys(cols).map((val) => (
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

                            {data && Object.entries(data.data).map(([key, value], index) => (
                                <tr
                                    className={`border-b ${index % 2 === 0 ? 'bg-gray-100' : 'bg-white'}`}
                                    key={"tr" + index}>
                                    <td className="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center"
                                        key={"td1" + key + value + index}>
                                        {value["id"]}

                                    </td>

                                    {Object.entries(cols).map(([colName, colType], colIndex) => (
                                        <td className="text-sm text-gray-900 font-light px-6 py-3 whitespace-nowrap"
                                            key={"td2" + colName + colType + colIndex}
                                        >
                                            {colType === "boolean" && (
                                                <BasicHooksExample
                                                    estat={Boolean(value[colName])}
                                                    onChange={(newCheckedState) => handleSwitch(value["id"], newCheckedState)}
                                                />
                                            )}
                                            {colType === "textArea" && (
                                                <textarea
                                                    value={rowEditing === index ? editedValues[colName] : value[colName]}
                                                    disabled={rowEditing !== index}
                                                    key={"td3_input" + colName + colType + colIndex}
                                                    onChange={(evt) => handleChange(evt, colName)}
                                                >
                                                </textarea>

                                            )}
                                            {colType !== "boolean" && colType !== "textArea" && (

                                                <InputTable
                                                    type={colType}
                                                    value={rowEditing === index ? editedValues[colName] : value[colName]}
                                                    disabled={rowEditing !== index}
                                                    key={"td3_input" + colName + colType + colIndex}
                                                    onChange={(evt) => handleChange(evt, colName)}
                                                />
                                            )}
                                        </td>
                                    ))}

                                    <td className="text-sm text-gray-900 font-light px-6 py-3 whitespace-nowrap justify-center flex">

                                        {rowEditing !== index && (
                                            <>
                                                <EditButton onClick={(evt) => handleEdit(evt, index, value)}/>
                                                <DeleteButton onClick={handleDelete}/>
                                            </>
                                        )}

                                        {editing && rowEditing === index && (
                                            <>
                                                <AcceptButton onClick={(evt) => handleAccept(evt, index)}/>
                                                <DenyButton onClick={(evt) => handleDeny(evt, index)}/>
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
