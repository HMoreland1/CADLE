import {useEffect, useState} from 'react';
import Canvas from './Canvas';
import PropertyEditor from './PropertyEditor';
import ComponentPalette from './ComponentPalette';
import LayoutPalette from './LayoutPalette';
import DeleteButton from './DeleteButton';
import {v4 as uuidv4} from 'uuid';
import '../../../../css/Editor.css';
import {DndProvider} from "react-dnd";
import {HTML5Backend} from "react-dnd-html5-backend";

const Editor = ({ startingRows, isEditing }) => {
    // State for managing canvas, component properties, etc.
    // State for managing canvas, component properties, etc.

    const [canvasRows, setCanvasRows] = useState([]);
    const [selectedComponentId, setSelectedComponentId] = useState(null);
    const [selectedColumn, setSelectedColumn] = useState(null);
    const [activeTab, setActiveTab] = useState('sidebar'); // State to track active tab
    // Update canvas_json whenever rowsData changes
    useEffect(() => {
        if (document.getElementById('canvas_json')){
            document.getElementById('canvas_json').value = JSON.stringify(canvasRows);
        }

    }, [canvasRows]);

    useEffect(() => {
            if(startingRows != null){
                try{
                    setCanvasRows(JSON.parse(startingRows.content));
                } catch (e) {
                    location.reload()
                    console.log("content invalid", e)
                }
            }
    }, []);

    // Save canvas rows to sessionStorage whenever canvasRows state changes
    useEffect(() => {
        sessionStorage.setItem('canvasRows', JSON.stringify(canvasRows));
    }, [canvasRows]);

    // Handlers for managing component properties
    const handlePropertyChange = (updatedProperties) => {
        const updatedRows = canvasRows.map(row => ({
            ...row,
            columns: row.columns.map(col => {
                if (col.id === selectedColumn.id) {
                    return {
                        ...col,
                        component: {
                            ...col.component,
                            properties: updatedProperties,
                        },
                    };
                }
                return col;
            }),
        }));
        setCanvasRows(updatedRows);
    };

    // Function to handle column selection
    const handleColumnSelect = (column) => {
        setSelectedColumn(column);
    };

    // Handlers for managing canvas
    const handleAddComponentToCanvas = (item, columnId) => {
        const targetRow = canvasRows.find(row => row.columns.some(col => col.id === columnId));
        const targetColumn = targetRow.columns.find(col => col.id === columnId);
        if (targetColumn) {
            targetColumn.component = {
                id: uuidv4(),
                type: item.type,
                properties: item.properties || {},
            };
            setCanvasRows([...canvasRows]);
        } else {
            console.error("Column not found in any row.");
        }

    };

// Function to delete a row with a given ID
    const handleDeleteRow = (rowId) => {
        setCanvasRows(canvasRows.filter(row => row.id !== rowId));
    };

    const handleDeleteComponentFromColumn = (columnId) => {
        const updatedRows = canvasRows.map(row => ({
            ...row,
            columns: row.columns.map(col => {
                if (col.id === columnId) {
                    return {
                        ...col,
                        component: null,
                    };
                }
                return col;
            }),
        }));
        setCanvasRows(updatedRows);
    };

    const handleAddLayoutToCanvas = (layout) => {
        const rowId = uuidv4();
        const newRow = {
            id: rowId,
            columns: layout.columns.map((column, columnIndex) => ({
                id: `${rowId}-${layout.id}-${columnIndex}`,
                type: 'Column',
                properties: {
                    width: column.width,
                },
                component: null,
            })),
        };
        setCanvasRows([...canvasRows, newRow]);
    };

    const predefinedLayouts = [
        {id: 1, name: 'Single Column', columns: [{width: 100}]},
        {id: 2, name: 'Two Columns (50/50)', columns: [{width: 50}, {width: 50}]},
        {id: 3, name: '3 Columns', columns: [{width: 33}, {width: 34}, {width: 33}]},
        {id: 4, name: '4 Columns', columns: [{width: 25}, {width: 25}, {width: 25}, {width: 25}]},
        {id: 5, name: '5 Columns', columns: [{width: 20}, {width: 20}, {width: 20}, {width: 20}, {width: 20}]},
        {id: 6, name: '5 Columns', columns: [{width: 5}, {width: 45}, {width: 45}, {width: 5}]}
    ];

    const handleDragStart = (event, component) => {
        event.dataTransfer.setData('componentType', component.type);
    };

    const handleTabSwitch = (tab) => {
        setActiveTab(tab);
    };

    return (
        <div className="editor-container">
            <input type="hidden" name="canvas_json" id="canvas_json"/>
            {isEditing ? (
                <DndProvider backend={HTML5Backend}>
                    {/* Tabs */}
                    <div className="tabs-container">
                        <div className="tabs">
                            <a className={`tab-item ${activeTab === 'sidebar' ? 'active' : ''}`}
                               onClick={() => handleTabSwitch('sidebar')}>Settings</a>
                            <a className={`tab-item ${activeTab === 'componentPalette' ? 'active' : ''}`}
                               onClick={() => handleTabSwitch('componentPalette')}>Components</a>
                        </div>
                        {/* Content */}
                        <div className="editor-content">
                            {/* Sidebar */}
                            <div className={`sidebar ${activeTab === 'sidebar' ? 'active' : ''}`}>
                                <PropertyEditor
                                    column={selectedColumn}
                                    onChange={handlePropertyChange}/>
                            </div>
                            {/* Component Palette */}
                            <div className={`component-palette ${activeTab === 'componentPalette' ? 'active' : ''}`}>
                                <ComponentPalette onDragStart={handleDragStart}/>
                            </div>
                        </div>
                    </div>
                    {/* Canvas */}
                    <div className="canvas-container">
                        <Canvas
                            isEditing={isEditing}
                            handleDeleteRow={handleDeleteRow}
                            rows={canvasRows}
                            selectedComponentId={selectedComponentId}
                            onSelectComponent={setSelectedComponentId}
                            onDeleteComponent={handleDeleteComponentFromColumn}
                            onDropComponent={handleAddComponentToCanvas}
                            onColumnClick={handleColumnSelect}
                        />
                        <LayoutPalette layouts={predefinedLayouts} onAddLayout={handleAddLayoutToCanvas}/>
                        {selectedComponentId && (
                            <DeleteButton onClick={() => handleDeleteComponentFromCanvas(selectedComponentId)}/>
                        )}
                    </div>
                </DndProvider>
            ) : (
                <DndProvider backend={HTML5Backend}>
                <div >
                    <Canvas
                        isEditing={isEditing}
                        handleDeleteRow={handleDeleteRow}
                        rows={canvasRows}
                        selectedComponentId={selectedComponentId}
                        onSelectComponent={setSelectedComponentId}
                        onDeleteComponent={handleDeleteComponentFromColumn}
                        onDropComponent={handleAddComponentToCanvas}
                        onColumnClick={handleColumnSelect}
                    />
                </div>
                </DndProvider>
            )}
        </div>
    );
};

export default Editor;
