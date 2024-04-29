import { useDrop } from 'react-dnd';

// Import the draggable components
import text from './DraggableComponents/Text.jsx';
import textTitle from './DraggableComponents/TextTitle.jsx';
import Email from './DraggableComponents/Email.jsx';
import Spacer from './DraggableComponents/Spacer.jsx';
import {FaTrash} from "react-icons/fa";

const componentMap = {
    text: text,
    textTitle: textTitle,
    email: Email,
    spacer: Spacer,
    // Add more component types and corresponding components as needed
};

const CanvasColumn = ({ isEditing, column, onDrop, onClick, onMouseEnterColumn, onMouseLeaveColumn, hoveredCol, onDeleteCol }) => {

    const [{ isOver }, drop] = useDrop({
        accept: 'component',
        drop: (item, monitor) => {
            // Retrieve dropped component type and properties
            const { type, component, properties } = item;
            // Perform actions based on dropped component type and properties
            // Here you can use the onDrop function to handle the dropped data
            onDrop(item, column.id);

            // You can also access additional information about the drop event, such as position
            const dropResult = monitor.getDropResult();
        },
        collect: (monitor) => ({
            isOver: monitor.isOver(),
        }),
    });

    // Get the corresponding component type from the component map
    const Component = column.component ? componentMap[column.component.type] : null;

    // Handle click event
    const handleClick = () => {
        // Pass column properties to onClick function
        onClick(column);
    };

    return (
        <div className="column-container"
             style={{width: `${column.properties.width}%`}}
             onMouseEnter={() => onMouseEnterColumn(column.id)} // Call onMouseEnterColumn when the mouse enters the column
             onMouseLeave={() => onMouseLeaveColumn(column.id)}>
            {hoveredCol === column.id && isEditing ?(
                <a
                    className="column-button"
                    onClick={() => onDeleteCol(column.id)}

                >
                    <FaTrash />
                </a>
            ): null}
        <div
            ref={drop}
            className={
                !isEditing ? "canvas-column no-border isEditing" :
                    column.component ? "canvas-column no-border" : "canvas-column"
            }


            onClick={handleClick} // Add onClick event handler
        >


            {/* Render the component object if it's not null */}
            <div
                style={{
                    width: '100%', // Ensure the component fills the column width
                    flexGrow: '1',
                }}
            >

                {Component && <Component {...column.component.properties} />}

            </div>

        </div>
        </div>
    );

};

export default CanvasColumn;
