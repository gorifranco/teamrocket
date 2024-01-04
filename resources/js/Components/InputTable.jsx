import React from 'react';

export default function InputTable({type, value, keyVal, disabled = true}) {

    function setType() {
        if (disabled && type === "date") {
            return "text"
        } else if (!disabled && type === "date") {
            return "date"
        }
        return "type"
    }


    function disabledClassName() {
        if (disabled) {
            return "border-0 bg-transparent"
        } else {
            return "border-1"
        }
    }

    return (
        <input
            type={setType()}
            value={(value !== null) ? value : ""}
            className={disabledClassName()}
            disabled={disabled}
            key={keyVal}
        />
    );
};

