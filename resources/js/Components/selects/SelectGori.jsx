export default function SelectGori({options, onChange, selected = -1, className}) {

    const handleChange = (event) => {
        const selectedIndex = event.target.selectedIndex;

        if(selectedIndex>0) {
            const selectedOption = options[selectedIndex-1];

            onChange({
                id: selectedOption.id,
                nom: selectedOption.nom,
            });
        }else{
            onChange(null)
        }
    };


    return (
        <>
            <select
                    className={"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 " +
                        "focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" +
                        " dark:focus:ring-blue-500 dark:focus:border-blue-500 " + className}
                    onChange={handleChange}>
                <option key={-1} value={""}></option>
                {options && options.length > 0 && options.map((option) => (
                    <option key={option.id} value={option.id} selected={selected === option.id}>
                        {option.nom}
                    </option>
                ))}
            </select>
        </>
    )
}
