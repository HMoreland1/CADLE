import React from 'react';
import { useDrag, useDrop } from 'react-dnd';

const LayoutMenu = () => {
    // Define layouts with their positions
    const layouts = [
        [
            { id: 'layout1-1', width: 50, height: 100 },
            { id: 'layout1-2', width: 50, height: 100 },
        ],
        [
            { id: 'layout2-1', width: 25, height: 100 },
            { id: 'layout2-2', width: 25, height: 100 },
            { id: 'layout2-3', width: 25, height: 100 },
            { id: 'layout2-4', width: 25, height: 100 },
        ],
        [
            { id: 'layout3-1', width: 25, height: 100 },
            { id: 'layout3-2', width: 50, height: 100 },
            { id: 'layout3-3', width: 25, height: 100 },
        ],
        [
            { id: 'layout4-1', width: 33, height: 100 },
            { id: 'layout4-2', width: 34, height: 100 },
            { id: 'layout4-3', width: 33, height: 100 },
        ],
        [
            { id: 'layout5-1', width: 20, height: 100 },
            { id: 'layout5-2', width: 20, height: 100 },
            { id: 'layout5-3', width: 20, height: 100 },
            { id: 'layout5-4', width: 20, height: 100 },
            { id: 'layout5-5', width: 20, height: 100 },
        ],
        [
            { id: 'layout6-1', width: 100, height: 100 },
        ],
        [
            { id: 'layout7-1', width: 80, height:100 },
            { id: 'layout7-2', width: 20, height:100 },
        ],
        // Define more layouts here as needed
    ];

    return (
        <div className="layout-menu-wrapper" style={{ height: '100%', overflow: 'hidden',  display: 'flex', justifyContent: 'center' }}>
            <div className="layout-menu" style={{ height: '100%', width:'80%', display: 'flex', justifyContent: 'space-between' }}>
                {/* Render layouts */}
                {layouts.map((layout, index) => (
                    <LayoutItem key={index} layout={layout}  isFirst={index === 0} />
                ))}
            </div>
        </div>
    );
};


const LayoutItem = ({ layout }) => {
    // Drag hook for layout item
    const [{ isDragging }, drag] = useDrag({
        type: 'layout',
        item: { type: 'layout', layout },
    });

    // Drop hook for layout item
    const [{ isOver }, drop] = useDrop({
        accept: 'layout',
        collect: (monitor) => ({
            isOver: monitor.isOver(),
        }),
    });

    // Render SVG images based on layout
    const totalWidth = layout.reduce((acc, cur) => acc + cur.width, 0) / 5;

    // Calculate scaling factor for the SVG boxes
    const scaleFactor = 100 / totalWidth;

    // Render SVG boxes based on layout
    const renderLayoutImages = () => {
        return (
            <div style={{ display: 'flex', flexDirection: 'row', height: '100%' }}>
                {layout.map((position, index) => {
                    const boxWidth = position.width * scaleFactor;
                    const viewBoxWidth = position.width + 20; // Adjusted to accommodate padding
                    return (
                        <svg key={index} width={`${boxWidth}%`} height="100%" viewBox={`0 0 ${viewBoxWidth} 100`} xmlns="http://www.w3.org/2000/svg">
                            {/* Add SVG rect element to represent the layout box with rounded corners */}
                            <rect width={`${position.width}`} height="100" rx="5" ry="5" fill="blue" />
                        </svg>
                    );
                })}
            </div>
        );
    };

    return (
        <div className="layout" ref={drag} style={{ margin:'10px', opacity: isDragging ? 0.5 : 1 }}>
            {renderLayoutImages()} {/* Render SVG images */}
            {layout.map((position, index) => (
                <div
                    key={position.id}
                    className="layout-dropzone"
                    style={{
                        width: `${position.width}%`,
                        height: `${position.height}%`,
                        marginRight: index < layout.length - 1 ? '5px' : '0', // Adjusted gap between boxes
                    }}
                    ref={drop}
                />
            ))}
            {/* Drop zone */}
            <div style={{ height: '100%', backgroundColor: isOver ? 'lightgray' : 'transparent' }} />
        </div>
    );
};

export default LayoutMenu;
