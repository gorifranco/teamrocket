import React from 'react';

export default function InputTable({type, value, keyVal, onChange, disabled = true}) {


    function setType() {
        return disabled && type === "date" ? "text" : type;
    }

    function disabledClassName() {
        return disabled ? "border-0 bg-transparent" : "border-1 bg-white";
    }

    return (
        <input
            type={setType()}
            value={(value !== null) ? value : ""}
            className={disabledClassName()}
            disabled={disabled}
            onChange={onChange}
            key={keyVal}
        />
    );
};
