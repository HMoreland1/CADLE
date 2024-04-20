
import { useDrag, useDrop } from 'react-dnd';

const LayoutMenu = () => {
    // Define layouts with their positions
    const layouts = [
        [
            { id: 'layout1-1', width: 100, height: 100 },
        ],
        [
            { id: 'layout2-1', width: 50, height: 100 },
            { id: 'layout2-2', width: 50, height: 100 },
        ],
        [
            { id: 'layout3-1', width: 33, height: 100 },
            { id: 'layout3-2', width: 34, height: 100 },
            { id: 'layout3-3', width: 33, height: 100 },
        ],
        [
            { id: 'layout4-1', width: 25, height: 100 },
            { id: 'layout4-2', width: 25, height: 100 },
            { id: 'layout4-3', width: 25, height: 100 },
            { id: 'layout4-4', width: 25, height: 100 },
        ],
        [
            { id: 'layout5-1', width: 20, height: 100 },
            { id: 'layout5-2', width: 20, height: 100 },
            { id: 'layout5-3', width: 20, height: 100 },
            { id: 'layout5-4', width: 20, height: 100 },
            { id: 'layout5-5', width: 20, height: 100 },
        ],
        [
            { id: 'layout6-1', width: 20, height: 100 },
            { id: 'layout6-2', width: 20, height: 100 },
            { id: 'layout6-3', width: 20, height: 100 },
            { id: 'layout6-4', width: 20, height: 100 },
            { id: 'layout6-5', width: 20, height: 100 },
        ],
        [
            { id: 'layout7-1', width: 20, height: 100 },
            { id: 'layout7-2', width: 40, height: 100 },
            { id: 'layout7-3', width: 40, height: 100 },
        ],
        [
            { id: 'layout8-1', width: 40, height: 100 },
            { id: 'layout8-2', width: 40, height: 100 },
            { id: 'layout8-3', width: 20, height: 100 },
        ],
        [
            { id: 'layout9-1', width: 25, height:100 },
            { id: 'layout9-2', width: 25, height:100 },
            { id: 'layout9-3', width: 50, height:100 },
        ],
        [
            { id: 'layout10-1', width: 50, height:100 },
            { id: 'layout10-2', width: 25, height:100 },
            { id: 'layout10-3', width: 25, height:100 },
        ],
        [
            { id: 'layout11-1', width: 25, height:100 },
            { id: 'layout11-2', width: 50, height:100 },
            { id: 'layout11-3', width: 25, height:100 },
        ],
        [
            { id: 'layout12-1', width: 15, height:100 },
            { id: 'layout12-2', width: 70, height:100 },
            { id: 'layout12-3', width: 15, height:100 },
        ],
        // Define more layouts here as needed
    ];

    return (
        <div className="layout-menu-wrapper"
             style={{ display: 'flex', justifyContent: 'center'}}>
            <div className="layout-menu"
                 style={{ width: '80%', display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(150px, 1fr))', gap: '10px'}}>
                {/* Render layouts */}
                {layouts.map((layout, index) => (
                    <LayoutItem key={index} layout={layout} isFirst={index === 0}/>
                ))}
            </div>
        </div>
    );



};


const LayoutItem = ({layout}) => {
    // Drag hook for layout item
    const [{isDragging}, drag] = useDrag({
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

    const renderSVGs = () => {
        const svgElements = [];

        layout.forEach((position, index) => {
            // Calculate the width of the current column
            const columnWidth = `${position.width}%`;

            // Add SVG for column
            svgElements.push(
                <div key={`column-${index}`} style={{ width: columnWidth, height: '100%' }}>
                    <svg width="100%" height="100%">
                        {/* Example content: a rectangle filling the entire SVG */}
                        <rect x="0" y="0" width="100%" height="100%" fill="gray" rx="5" ry="5"/>
                    </svg>
                </div>
            );

            // Add space between columns except for the last one
            if (index !== layout.length - 1) {
                svgElements.push(
                    <div key={`space-${index}`} style={{ width: '10px', height: '100%' }} />
                );
            }
        });

        return svgElements;
    };
    return (
        <div className="layout" ref={drag}
             style={{width: '75%', margin: 'auto', opacity: isDragging ? 0.5 : 1}}>
            <div style={{display: 'flex', flexDirection: 'row', height: '100%'}}>
                {renderSVGs()}
            </div>


            {layout.map((position, index) => (
                <div
                    key={position.id}
                    className="layout-dropzone"
                    style={{
                        width: `${position.width}%`,
                        margin: '5px', // Adjusted gap between boxes
                    }}
                    ref={drop}
                />
            ))}
        </div>
    );
};

export default LayoutMenu;
