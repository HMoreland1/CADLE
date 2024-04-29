// LayoutPalette.jsx

const LayoutPalette = ({layouts, onAddLayout}) => {

    return (
        <div className="layout-palette-container" ><h3>Click on a layout below to get started</h3>
            <div className="layout-palette">

                {layouts.map((layout, index) => (
                    <div key={index} className="layout-layout" onClick={() => onAddLayout(layout)}>
                        <div className="layout-row">
                            {layout.columns.map((column, columnIndex) => (
                                <div key={columnIndex} className="layout-item" style={{width: `${column.width}%`}}>
                                    <svg width="100%" height="100%">
                                        <rect x="0" y="0" width="100%" height="100%" fill="grey" rx="5" ry="5"/>
                                    </svg>
                                </div>
                            ))}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default LayoutPalette;
