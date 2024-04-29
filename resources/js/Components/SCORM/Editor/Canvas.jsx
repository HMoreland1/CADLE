// Canvas.jsx
import {useState} from 'react';
import '../../../../css/Canvas.css';
import CanvasRow from './CanvasRow';

const Canvas = ({isEditing, rows, onSelectComponent, onDropComponent, onColumnClick, handleDeleteRow, onDeleteComponent}) => {
    const [hoveredRow, setHoveredRow] = useState();
    const [hoveredCol, setHoveredCol] = useState();

    const handleRowHover = (rowId, isHovering) => {
        if(isEditing)
        {
            setHoveredRow(isHovering ? rowId : null);
        }

    };
    const handleColHover = (colId, isHovering) => {
        if(isEditing) {
            setHoveredCol(isHovering ? colId : null);
        }
    };

    return (
        <div className="canvas">
            <div className="rows-container">
            {rows.map((row) => (

                    <CanvasRow
                        isEditing = {isEditing}
                        onDeleteCol={onDeleteComponent}
                        handleDeleteRow={handleDeleteRow}
                        setHoveredCol={handleColHover}
                        hoveredCol={hoveredCol}
                        handleRowHover={handleRowHover}
                        hoveredRow={hoveredRow}
                        key={row.id}
                        row={row.id}
                        columns={row.columns}
                        onSelectComponent={onSelectComponent}
                        onDrop={onDropComponent}
                        onColumnClick={onColumnClick}
                        onMouseEnter={() => handleRowHover(row.id, true)}
                        onMouseLeave={() => handleRowHover(row.id, false)}
                    />
            ))}
            </div>
        </div>
    );
};

export default Canvas;
