export default function EditButton({onClick}) {
    return (
        <button
            onClick={onClick}
            className={"text-white bg-green-700 hover:bg-green-500 focus:ring-2 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm text-center inline-flex items-center me-2 px-3 py-2"}>
            Editar
        </button>
    )
}
