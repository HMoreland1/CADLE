import React, { useState } from 'react';
import Sidebar from './Sidebar';
import PropertyEditor from './PropertyEditor';
import Canvas from './Canvas';
import { DndProvider } from 'react-dnd';
import { HTML5Backend } from 'react-dnd-html5-backend';
import '../../../../css/VisualEditor.css';
import Menu from './Menu.jsx';
import Button from './Components/Button';
import TextInput from "@/Components/TextInput.jsx";
import Checkbox from "@/Components/Checkbox.jsx";
import ScormUtils from './SCORMUtils';
import LayoutMenu from "@/Components/SCORM/Creator/LayoutMenu.jsx";
import InfoBlock from "@/Components/SCORM/Creator/Components/InfoBlock.jsx"; // Import the SCORM utility functions

const VisualEditor = () => {
    const [selectedComponent, setSelectedComponent] = useState(null);
    const [rows, setRows] = useState([]); // State to hold canvas rows

    const components = [
        { component: <Button placeholder="Enter text" />, title: "Button" },
        { component: <TextInput placeholder="Enter text" />, title: "Text Input" },
        { component: <Checkbox label="Check me" />, title: "Checkbox" },
        { component: <InfoBlock />, title: "Info Block" }
        // Add more components here
    ];


    const handleSave = () => {
        // Step 1: Generate HTML content
        const htmlContent = ScormUtils.generateHTMLContent(rows);

        // Step 2: Generate SCORM manifest
        const scormManifest = ScormUtils.generateSCORMManifest(htmlContent);

        // Step 3: Package SCORM content
        const scormPackage = ScormUtils.packageSCORMContent(htmlContent, scormManifest);

        // Step 4: Export SCORM package
        ScormUtils.exportSCORMPackage(scormPackage);
    };


    const handleExport = () => {
        // Implement export functionality
    };

    const handleComponentSelect = (component) => {
        // Handle component selection
    };

    return (
        <div className="visual-editor" style={{display: 'flex'}}>
            <DndProvider backend={HTML5Backend}>
                <div style={{width: '15%', height: '100%', display: 'flex', flexDirection: 'column'}}>
                    <div className="sidebar" style={{height: '95%', backgroundColor: 'lightblue'}}>
                        <Sidebar components={components} onSelectComponent={handleComponentSelect}/>
                    </div>
                    <div style={{height: '5%', backgroundColor: 'lightgreen'}}>
                        <Menu onSave={handleSave} onExport={handleExport}/> {/* Pass handleSave as onSave prop */}
                    </div>
                </div>
                <div style={{width: '70%', height: '100%', display: 'flex', flexDirection: 'column'}}>
                    <div className="canvas" style={{height: '95%', backgroundColor: 'blue'}}>
                        <Canvas selectedComponent={selectedComponent} rows={rows}
                                setRows={setRows}/> {/* Pass rows and setRows as props */}
                    </div>
                    <div className="layout-menu-container"
                         style={{height: '10%', width: '100%', backgroundColor: 'lightyellow'}}>
                        <LayoutMenu/>
                    </div>
                </div>
                <div className="property-editor" style={{height: '100%', width: '15%', backgroundColor: 'lightcoral'}}>
                    <PropertyEditor selectedComponent={selectedComponent}/>
                </div>
            </DndProvider>
        </div>
    );
};

export default VisualEditor;
