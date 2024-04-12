import React, { useState, useEffect } from 'react';

const PropertyEditor = ({ selectedComponent, onPropertyChange }) => {
    const [inputValues, setInputValues] = useState({});

    useEffect(() => {
        if (selectedComponent && selectedComponent.props) {
            setInputValues(selectedComponent.props);
        }
    }, [selectedComponent]);

    const handleChange = (property, value) => {
        // Update the input values state
        const updatedInputValues = {
            ...inputValues,
            [property]: value
        };
        setInputValues(updatedInputValues);

        // Call the onPropertyChange callback to update the canvas component
        onPropertyChange(property, value);
    };

    const renderProperties = () => {
        return Object.keys(inputValues).map(property => (
            <div className="property" key={property}>
                <label>{property}:</label>
                <input
                    type="text"
                    value={inputValues[property]}
                    onChange={e => handleChange(property, e.target.value)}
                />
            </div>
        ));
    };

    return (
        <div className="property-editor">
            {selectedComponent && selectedComponent.type &&
                <h2>{selectedComponent.type} Properties</h2>
            }
            {renderProperties()}
        </div>
    );
};

export default PropertyEditor;
