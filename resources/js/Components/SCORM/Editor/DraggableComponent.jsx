import { useDrag } from 'react-dnd';
import { v4 as uuidv4 } from 'uuid';

const DraggableComponent = ({ component }) => {
    console.log("type: ", component.type);
    const [{ isDragging }, drag] = useDrag({
        type: 'component',
        item: () => ({ type: "component", component: component, id: uuidv4() }), // Define the item to be dragged
        collect: (monitor) => ({
            isDragging: !!monitor.isDragging(),
        }),
    });


    return (
        <div
            ref={drag}
            className="draggable-component"
            style={{ opacity: isDragging ? 0.5 : 1 }}
        >
            {component.label}
        </div>
    );
};

export default DraggableComponent;
