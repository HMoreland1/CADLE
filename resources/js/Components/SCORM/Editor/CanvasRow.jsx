import { useState } from 'react';
import CanvasColumn from './CanvasColumn';
import { FaTrash } from "react-icons/fa";

const CanvasRow = ({ isEditing, row, hoveredCol, setHoveredCol, columns, onSelectComponent, onDrop, onColumnClick, hoveredRow, handleRowHover, handleDeleteRow, onDeleteCol}) => {
    const [isAnyColumnHovered, setIsAnyColumnHovered] = useState(false);

    const onMouseEnterColumn = (columnId) => {
        if(isEditing){
            setIsAnyColumnHovered(true);
            setHoveredCol(columnId, true)
        }

    };

    const onMouseLeaveColumn = (columnId) => {
        if(isEditing){
            setIsAnyColumnHovered(false);
            setHoveredCol(columnId, false)
        }

    };


    return (
        <div className="row-container"
             onMouseEnter={()=>handleRowHover(row, true)}
             onMouseLeave={()=>handleRowHover(row, false)}>
            <div className={`canvas-row ${isAnyColumnHovered || !isEditing ? 'hovered-column' : ''}`}>
            {columns.map(column => (
                    <CanvasColumn
                        isEditing = {isEditing}
                        key={column.id}
                        hoveredCol={hoveredCol}
                        column={column}
                        onSelectComponent={onSelectComponent}
                        onDrop={onDrop}
                        onClick={onColumnClick}
                        onMouseEnterColumn={() =>onMouseEnterColumn(column.id)}
                        onMouseLeaveColumn={() =>onMouseLeaveColumn(column.id)}
                        onDeleteCol={onDeleteCol}
                    />
                ))}
                {!isAnyColumnHovered && hoveredRow === row && isEditing ? ( // Only show the delete button if the row is hovered
                    <a
                        className="row-button"
                        onClick={() => handleDeleteRow(row)}
                    >
                        <FaTrash/>
                    </a>
                ) : null}
            </div>
        </div>
    );
};

export default CanvasRow;
