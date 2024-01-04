export default function DeleteButton({onClick}) {
    return (
        <button
            onClick={onClick}
            className={"text-white bg-red-700 hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm text-center inline-flex items-center me-2 px-3 py-2"}>
            Eliminar
        </button>
    )
}
