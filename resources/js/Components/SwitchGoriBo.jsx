import {useState} from "react";
import Switch from "react-switch";

export default function BasicHooksExample ({estat, onChange})  {
    const [checked, setChecked] = useState(estat);
    const handleChange = () => {
        const newCheckedState = !checked;
        setChecked(newCheckedState);
        onChange(newCheckedState);
    };
    return (
        <div className="example">
            <label>
                <Switch
                    onChange={handleChange}
                    checked={checked}
                    className="react-switch"
                    offColor={"#B22222"}
                />
            </label>
        </div>
    );
};
