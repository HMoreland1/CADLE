// PropertyEditor.js
import React from 'react';

const PropertyEditor = ({ selectedComponent }) => {
    return (
        <div className="property-editor">
            {selectedComponent && (
                <>
                    <h2>{selectedComponent} Properties</h2>
                    {/* Render property editor for selected component */}
                    {/* Example: */}
                    <div className="property">
                        <label>Background Color:</label>
                        <input type="color" />
                    </div>
                    <div className="property">
                        <label>Text:</label>
                        <input type="text" />
                    </div>
                </>
            )}
        </div>
    );
};

export default PropertyEditor;
