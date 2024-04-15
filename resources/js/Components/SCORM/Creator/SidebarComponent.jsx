import React from 'react';
import { useDrag } from 'react-dnd';

const SidebarComponent = ({ componentObj, columnIndex }) => {
    const [{ isDragging }, drag] = useDrag({
        type: 'component',
        item: { type: 'component', component: componentObj.component, columnIndex },
        collect: (monitor) => ({
            isDragging: monitor.isDragging(),
        }),
    });

    return (
        <div className="sidebar-component" style={{ opacity: isDragging ? 0.5 : 1 }}>
            <button ref={drag}>{componentObj.title}</button>
        </div>
    );
};

export default SidebarComponent;
