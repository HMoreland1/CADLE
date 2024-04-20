
import { useDrag } from 'react-dnd';
import {v4 as uuidv4} from "uuid";

const SidebarComponent = ({ componentObj, columnIndex }) => {
    const [{ isDragging }, drag] = useDrag({
        type: 'component',
        item: { type: 'component', component: componentObj.component, title: componentObj.title, json: componentObj.json, columnIndex, id: uuidv4()},
        collect: (monitor) => ({
            isDragging: monitor.isDragging(),
        }),
    });

    return (
        <div title={componentObj.title} className="sidebar-component" style={{ opacity: isDragging ? 0.5 : 1 }}>
            <div ref={drag}>{componentObj.title}</div>
        </div>
    );
};

export default SidebarComponent;
