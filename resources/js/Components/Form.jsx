import PrimaryButton from "@/Components/PrimaryButton.jsx";

export default function Form({className = '', titol, handleSubmit, children, ...props}) {

    return (
        <div className={"flex flex-row min-h-screen justify-center items-center"}>
            <form className={"bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-xs" + className}
                  onSubmit={handleSubmit}>
                <div className={"text-center font-bold"}>{titol}</div>
                {children}
                <div className={"flex justify-center"}>
                    <PrimaryButton
                        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    >
                        Crear
                    </PrimaryButton>
                </div>

            </form>
        </div>
    );
}
