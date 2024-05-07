import { useState, useEffect, useRef } from 'react';
import '../../../../css/PropertyEditor.css';
import QuillEditor from "@/Components/SCORM/Editor/Quill/QuillEditor.jsx";

const PropertyEditor = ({ column, onChange }) => {
    const [properties, setProperties] = useState(column?.component?.properties || {});
    const [inputValues, setInputValues] = useState({});
    const quillRef = useRef(null); // Create a ref for QuillEditor
    const [updateProps, setUpdateProps] = useState(null);
    // Update local state when the column prop changes
    useEffect(() => {
        if (column?.component?.properties) {
            setProperties(column?.component?.properties || {})
        }

    }, [column,updateProps]);


    useEffect(() => {

    }, [updateProps]);

    // Update input values when properties change
    useEffect(() => {
        setInputValues(Object.fromEntries(
            Object.entries(properties).map(([property, values]) => [property, values[0]?.value || ''])
        ));
    }, [properties]); // Update only when properties change

    const handleChange = (property, value) => {
        // Update the specific property
        try{
            const updatedProperties = {
                ...properties,
                [property]: [{ ...properties[property][0], value }]
            };

            // Propagate the changes to the parent component
            onChange(updatedProperties);

            // Update the local state
            setProperties(updatedProperties);

        } catch (e){
            console.log("Properties unavailable at this time.")
        }

    };
    const handleQuillChange = (property, value) => {
        // Update the value directly in the properties
        handleChange(property, value);
    };
    return (
        <div className="property-editor">
            {column && column.component && column.component.properties &&
                Object.entries(column.component.properties).map(([property, values]) => (
                    <div key={property} className="property">
                        <label className="label" htmlFor={property}>{property}</label>
                        {values[0].input === 'alignment' ? (
                            <select
                                id={property}
                                value={inputValues[property]}
                                onChange={(event) => handleChange(property, event.target.value)}
                            >
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                                <option value="right">Right</option>
                            </select>
                        ) : values[0].input === 'paragraph' && properties ? (

                            properties && values[0].input === 'paragraph' && (
                                <QuillEditor
                                    column={column}
                                    value={values[0].value}
                                    onChange={(value) => handleChange(property, value)}
                                />
                            )
                        ) : (

                            <input
                                className="property-input"
                                type={values[0].input} // Use input type from properties
                                id={property}
                                value={inputValues[property]}
                                onChange={(event) => handleChange(property, event.target.value)}
                            ></input>
                        )}
                    </div>

                ))
            }
        </div>
    );
};

export default PropertyEditor;
