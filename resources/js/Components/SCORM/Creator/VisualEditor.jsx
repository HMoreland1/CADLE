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
import LayoutMenu from "@/Components/SCORM/Creator/LayoutMenu.jsx";
import InfoBlock from "@/Components/SCORM/Creator/Components/InfoBlock.jsx";
import ScormUtils from "@/Components/SCORM/Creator/SCORMUtils.jsx"; // Import the InfoBlock component

const VisualEditor = () => {
    const [selectedComponent, setSelectedComponent] = useState({ props: {} }); // Initialize selectedComponent with props

    const [rows, setRows] = useState([]); // State to hold canvas rows
    const [canvasComponents, setCanvasComponents] = useState([]); // State to hold canvas components


    const components = [
        { component: <Button color={'#ffffff'} />, title: "Button" },
        { component: <TextInput placeholder="Enter text" />, title: "Text Input" },
        { component: <Checkbox label="Check me" />, title: "Checkbox" },
        { component: <InfoBlock title="test" text="test" />, title: "Info Block" }
        // Add more components here
    ];

    const handlePropertyChange = (property, value) => {
        if (!selectedComponent) return;

        // Find the index of the selected component in the canvas components
        const index = canvasComponents.findIndex(component => component.id === selectedComponent.id);
        if (index !== -1) {
            // Update the selected property of the component
            const updatedComponent = {
                ...canvasComponents[index],
                props: {
                    ...canvasComponents[index].props,
                    [property]: value
                }
            };
            // Create a new array of canvas components with the updated component
            const updatedCanvasComponents = [...canvasComponents];
            updatedCanvasComponents[index] = updatedComponent;
            // Update the canvas components state
            setCanvasComponents(updatedCanvasComponents);
        }
    };2



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
        console.log("Selected component:", component);
        setSelectedComponent(component);
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
                        <Canvas
                            components={components}
                            rows={rows}
                            setRows={setRows}
                            selectedComponent={selectedComponent}
                            setSelectedComponent={setSelectedComponent} // Pass setSelectedComponent here
                        /> {/* Pass rows and setRows as props */}
                    </div>
                    <div className="layout-menu-container"
                         style={{height: '10%', width: '100%', backgroundColor: 'lightyellow'}}>
                        <LayoutMenu/>
                    </div>
                </div>
                <div className="property-editor" style={{height: '100%', width: '15%', backgroundColor: 'lightcoral'}}>
                    {/* Render the PropertyEditor component with the selectedComponent prop */}
                    <PropertyEditor
                        selectedComponent={selectedComponent}
                        onPropertyChange={handlePropertyChange}
                    />
                </div>
            </DndProvider>
        </div>
    );
};

export default VisualEditor;
