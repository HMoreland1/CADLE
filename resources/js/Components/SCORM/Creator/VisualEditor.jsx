import React, {useState} from 'react';
import Sidebar from './Sidebar';
import PropertyEditor from './PropertyEditor';
import Canvas from './Canvas';
import {DndProvider} from 'react-dnd';
import {HTML5Backend} from 'react-dnd-html5-backend';
import '../../../../css/VisualEditor.css';
import Menu from './Menu.jsx';
import Button from './Components/Button';
import TextInput from "@/Components/TextInput.jsx";
import Checkbox from "@/Components/Checkbox.jsx";
import LayoutMenu from "@/Components/SCORM/Creator/LayoutMenu.jsx";
import InfoBlock from "@/Components/SCORM/Creator/Components/InfoBlock.jsx";

const VisualEditor = () => {
    const [selectedComponent, setSelectedComponent] = useState({ props: {} }); // Initialize selectedComponent with props
    const [rows, setRows] = useState([]); // State to hold canvas rows


    const components = [
        {
            title: "Button",
            component: <Button color={'#111111'} />,
            json: { type: "Button", props: { color: '#111111' } }
        },
        {
            title: "Text Input",
            component: <TextInput placeholder="Enter text" />,
            json: { type: "Text Input", props: { placeholder: "Enter text" } }
        },
        {
            title: "Checkbox",
            component: <Checkbox label="Check me" />,
            json: { type: "Checkbox", props: { label: "Check me" } }
        },
        {
            title: "Info Block",
            component: <InfoBlock name="test" title="test" text="test" alignment="left" />,
            json: {
                type: "Info Block",
                props: {
                    title: {
                        type: "text",
                        default: "test",
                        label: "Title"
                    },
                    text: {
                        type: "textarea",
                        default: "test",
                        label: "Text"
                    }

                }
            }
        }

        // Add more components here
    ];
    const handlePropertyChange = (componentId, updatedProps) => {
        // Update the rows state to reflect the changes in the selected component
        const updatedRows = rows.map(row => {
            return {
                ...row,
                columns: row.columns.map(column => {
                    return {
                        ...column,
                        components: column.components.map(comp => {
                            // Check if this is the selected component
                            if (comp.id === componentId) {
                                // Update the component's props
                                return {
                                    ...comp,
                                    component: React.cloneElement(comp.component, updatedProps)
                                };
                            }
                            return comp;
                        })
                    };
                })
            };
        });

        console.log("test",updatedRows);
        // Update the rows state
        setRows(updatedRows);
        console.log("test2",rows);
    };












    const handleSave = () => {

        const canvasJSON = Canvas.canvasStateToJSON(rows);
        console.log("Canvas JSON:", canvasJSON);

        // Step 1: Generate HTML content
        /*const htmlContent = ScormUtils.generateHTMLContent(rows);

        // Step 2: Generate SCORM manifest
        const scormManifest = ScormUtils.generateSCORMManifest(htmlContent);

        // Step 3: Package SCORM content
        const scormPackage = ScormUtils.packageSCORMContent(htmlContent, scormManifest);

        // Step 4: Export SCORM package
        ScormUtils.exportSCORMPackage(scormPackage);*/


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
                    <div style={{height: '5%'}}>
                        <Menu onSave={handleSave} onExport={handleExport}/> {/* Pass handleSave as onSave prop */}
                    </div>
                </div>
                <div style={{ width: '70%', height: '100%', display: 'flex', flexDirection: 'column' }}>
                    <div className="canvas"
                         style={{minHeight: '20%', overflowY: 'auto'}}>
                        <Canvas
                            components={components}
                            rows={rows}
                            setRows={setRows}
                            selectedComponent={selectedComponent}
                            setSelectedComponent={setSelectedComponent} // Pass setSelectedComponent here
                        /> {/* Pass rows and setRows as props */}
                    </div>
                    <div className="layout-menu-container"
                         style={{minHeight:'10%',maxHeight:'30%', overflowY: 'auto', width: '100%'}}>
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
