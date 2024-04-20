import React, {useEffect, useState} from 'react';
import { useDrop } from 'react-dnd';
import { FaTrash } from 'react-icons/fa';
import { v4 as uuidv4 } from 'uuid';

const Canvas = ({ components, rows, setRows, selectedComponent, setSelectedComponent, existingCanvasObject }) => {
    // State for hovered row and column
    const [hoveredRow, setHoveredRow] = useState(null);
    const [hoveredColumn, setHoveredColumn] = useState(null);
    // Function to generate unique row IDs
    let nextRowId = 0;
    const generateRowId = () => {
        nextRowId += 1;
        console.log(nextRowId);
        return nextRowId;
    };

    useEffect(() => {
        const canvasJSON = canvasStateToJSON(rows);
        console.log("Canvas JSON:", JSON.stringify(canvasJSON, null, 2)); // Stringify JSON object and log to console
    }, [rows]);



    const canvasStateToJSON = (rows) => {
        return {
            canvas: {
                rows: rows.map(row => ({
                    id: row.id,
                    style: row.style, // Store row style
                    columns: row.columns.map(column => ({
                        id: column.id,
                        width: column.width,
                        style: column.style, // Store column style
                        components: column.components.map(component => ({
                            id: component.id,
                            title: component.json,
                            style: component.style // Store component style
                        }))
                    }))
                }))
            }
        };
    };
    const updateRowsState = (updatedRows) => {
        setRows(updatedRows);
        const canvasJSON = canvasStateToJSON(updatedRows);
        // Save canvas JSON or perform other operations with it
    };
    // Load canvas from JSON
    const loadCanvasFromJSON = (json) => {
        const { canvas } = json;
        const loadedRows = canvas.rows.map(row => ({
            id: row.id,
            columns: row.columns.map(column => ({
                width: column.width,
                components: column.components.map(componentName => {
                    // Search for component by name
                    const foundComponent = components.find(component => component.name === componentName);
                    return foundComponent ? foundComponent : null;
                })
            }))
        }));
        setRows(loadedRows); // Update canvas state directly
    };

    useEffect(() => {
        if (existingCanvasObject) {
            loadCanvasFromJSON(existingCanvasObject);
        }
    }, [existingCanvasObject]);





    // Function to handle deletion of component from column
    const handleDeleteComponent = (rowId, columnIndex) => {
        const updatedRows = rows.map(row => {
            if (row.id === rowId) {
                const updatedColumns = row.columns.map((column, index) => {
                    if (index === columnIndex) {
                        return { ...column, components: [] };
                    }
                    return column;
                });
                return { ...row, columns: updatedColumns };
            }
            return row;
        });
        updateRowsState(updatedRows);
    };


    // Function to handle delete button state for a specific row
    const handleDeleteRow = (rowId) => {
        const updatedRows = rows.filter(row => row.id !== rowId);
        updateRowsState(updatedRows);
    };

    // Function to handle hover state for rows
    const handleRowHover = (rowId, isHovering) => {
        setHoveredRow(isHovering ? rowId : null);
    };

    // Function to handle hover state for columns
    const handleColumnHover = (columnIndex, isHovering) => {
        setHoveredColumn(isHovering ? columnIndex : null);
    };

    // Function to handle drop layout
    const handleDropLayout = (layout) => {
        const newRow = { id: uuidv4(), columns: layout.map(column => ({ id: uuidv4(), width: column.width, components: [] })) };
        setRows([...rows, newRow]);
    };

    // Function to handle drop component
    const handleDropComponent = (item, rowId, columnIndex) => {
        const { component, title, json } = item;


        // Add the new component to the canvas with its ID
        const updatedRows = rows.map(row => {
            if (row.id === rowId) {
                const updatedColumns = row.columns.map((column, index) => {
                    if (index === columnIndex) {
                        return { ...column, components: [{ id: uuidv4(), component, title, json }] };
                    }
                    return column;
                });
                return { ...row, columns: updatedColumns };
            }
            return row;
        });
        updateRowsState(updatedRows);
    };





    // DnD hook for layout drop
    const [, layoutDrop] = useDrop({
        accept: 'layout',
        drop: (item) => {
            handleDropLayout(item.layout);
        },
        collect: (monitor) => ({
            isOver: monitor.isOver(),
        }),
    });

    // DnD hook for component drop
    const [, componentDrop] = useDrop({
        accept: 'component',
        drop: (item, monitor) => {
            const { rowId } = item;
            const dropPosition = monitor.getClientOffset(); // Get drop position
            const rowElement = document.getElementById(`canvas-row-${rowId}`);
            if (!rowElement) return;
            const boundingRect = rowElement.getBoundingClientRect();
            const rowWidth = boundingRect.width;
            const columnWidths = row.columns.map(column => column.width * (rowWidth / 100)); // Calculate width of each column


            let cumulativeWidth = 0;
            let columnIndex = 0;
            // Determine column index based on drop position within row
            for (let i = 0; i < columnWidths.length; i++) {
                cumulativeWidth += columnWidths[i];
                if (dropPosition.x < boundingRect.left + cumulativeWidth) {
                    columnIndex = i;
                    break;
                }
            }
            console.log(columnIndex);
            const updatedRows = rows.map(row => {
                if (row.id === rowId) {
                    const updatedColumns = row.columns.map((column, index) => {
                        if (index === columnIndex) {
                            return { ...column, components: [item.component] };
                        }
                        return column;
                    });
                    return { ...row, columns: updatedColumns };
                }
                return row;
            });
            setRows(updatedRows);
        },
    });

    // Column component
    // Column component
    const Column = ({ rowId, columnIndex, column, handleDropComponent }) => {
        const [, componentDrop] = useDrop({
            accept: 'component',
            drop: (item) => handleDropComponent(item, rowId, columnIndex),
        });

        const [isColumnHovered, setIsColumnHovered] = useState(false);

        // Determine if the column has components
        const hasComponents = column.components.length > 0;

        // Assign the appropriate class based on whether the column has components
        const columnClass = hasComponents ? 'column with-components' : 'column no-components';

        return (
            <div
                className={columnClass}
                style={{
                    backgroundColor: isColumnHovered ? 'lightgray' : 'transparent',
                    width: `${column.width}%`,
                    position: 'relative',
                }}
                onMouseEnter={() => setIsColumnHovered(true)}
                onMouseLeave={() => setIsColumnHovered(false)}
                onClick={() => {
                    if (column.components.length > 0) {
                        setSelectedComponent(column.components[0].component); // Select the component
                    } else {
                        setSelectedComponent(null); // Clear selectedComponent if no components are present
                    }
                }}

                ref={componentDrop}
            >
                <div className="column-content">
                    {column.components.length > 0 && (
                        <div className="component">
                            {column.components[0].component}
                        </div>
                    )}
                </div>

                {isColumnHovered && hasComponents && (
                    <div className="delete-button-container"
                         style={{ position: 'absolute', top: '-13px', left: '50%', transform: 'translateX(-50%)', zIndex: 1 }}>
                        <button
                            className="delete-button"
                            style={{
                                backgroundColor: 'navy',
                                color: 'white',
                                border: 'none',
                                borderRadius: '50%',
                                padding: '5px',
                                cursor: 'pointer',
                                zIndex: 10,
                            }}
                            onClick={() => handleDeleteComponent(rowId, columnIndex)} // Ensure proper parameters are passed
                        >
                            <FaTrash />
                        </button>
                    </div>
                )}
            </div>
        );
    };


    return (
        <div className="canvas-container" style={{ display: 'flex', flexDirection: 'column', width: '100%', height: '100%', justifyContent: 'flex-start' }}>
            <div className="canvas" ref={layoutDrop} style={{ flexGrow: 1, display: 'flex', flexDirection: 'column' }}>
                {rows.map((row, rowIndex) => (
                    <div key={row.id} style={{ position: 'relative', minHeight: '10%', width: '80%', margin: '5px auto' }}
                         className="canvas-row" id={`canvas-row-${row.id}`}
                         onMouseEnter={() => handleRowHover(row.id, true)}
                         onMouseLeave={() => handleRowHover(row.id, false)}>
                        <div className="row-content" style={{ display: 'flex', alignItems: 'center', width: '100%', height: '100%', padding: '20px', border: hoveredRow === row.id ? '1px solid black' : 'none' }}>
                            {row.columns.map((column, columnIndex) => (
                                <Column
                                    key={columnIndex}
                                    rowId={row.id}
                                    columnIndex={columnIndex}
                                    column={column}
                                    hoveredRow={hoveredRow}
                                    hoveredColumn={hoveredColumn}
                                    handleColumnHover={handleColumnHover}
                                    handleDropComponent={handleDropComponent}
                                />
                            ))}
                        </div>

                        {hoveredRow === row.id && (
                            <div style={{ position: 'absolute', top: '-13px', left: '50%', transform: 'translateX(-50%)', zIndex: 1 }}>
                                <button
                                    className="delete-button"
                                    style={{ backgroundColor: 'navy', color: 'white', border: 'none', borderRadius: '50%', padding: '5px', cursor: 'pointer' }}
                                    onClick={() => handleDeleteRow(row.id)}
                                >
                                    <FaTrash/>
                                </button>
                            </div>
                        )}
                    </div>
                ))}
            </div>
        </div>
    );
};

export default Canvas;
