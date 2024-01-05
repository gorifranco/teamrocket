import React, {useState} from 'react';

export default function InputTable({type, value, keyVal, disabled = true}) {

    const [isDisabled, setDisabled] = useState(disabled)

    function toggleDisabled() {
        setDisabled(!isDisabled);
    }

    function setType() {
        return isDisabled && type === "date" ? "text" : type;
    }

    function disabledClassName() {
        return isDisabled ? "border-0 bg-transparent" : "border-1 bg-black";
    }

    return (
        <input
            type={setType()}
            value={(value !== null) ? value : ""}
            className={disabledClassName()}
            disabled={isDisabled}
            key={keyVal}
        />
    );
};
