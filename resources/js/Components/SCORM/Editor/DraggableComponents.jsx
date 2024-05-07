import {useDrag} from 'react-dnd';

const DraggableFlipTile = ({title, text}) => {
    const [{isDragging}, drag] = useDrag({
        type: 'component',
        item: {
            type: 'tile',
            properties: {
                title: [{input: 'text', value: title}],
                text: [{input: 'paragraph', value: text}]
            }
        },
        collect: (monitor) => ({
            isDragging: !!monitor.isDragging(),
        }),
    });

    const label = "Tile"
    return (tile({isDragging, drag, label}));
};

const DraggableImage = ({width, height}) => {
    const [{isDragging}, drag] = useDrag({
        type: 'component',
        item: {
            type: 'tile',
            properties: {
                width: [{input: 'text', value: width}],
                height: [{input: 'text', value: height}]
            }
        },
        collect: (monitor) => ({
            isDragging: !!monitor.isDragging(),
        }),
    });

    const label = "Tile"
    return (tile({isDragging, drag, label}));
};

const DraggableText = ({text = "Text", alignment = "left"}) => {
    const [{isDragging}, drag] = useDrag({
        type: 'component',
        item: {
            type: 'text', properties: {
                text: [{input: 'paragraph', value: text}],
                alignment: [{input: 'alignment', value: alignment}]
            }
        },
        collect: (monitor) => ({
            isDragging: !!monitor.isDragging(),
        }),
    });

    const label = "Text"
    return (tile({isDragging, drag, label}));
};

const DraggableTextTitle = ({title, text, alignment="left"}) => {
    const [{isDragging}, drag] = useDrag({
        type: 'component',
        item: {
            type: 'textTitle',
            properties: {
                title: [{input: 'text', value: title}],
                text: [{input: 'paragraph', value: text}],
                alignment: [{input: 'alignment', value: alignment}]
            }
        },
        collect: (monitor) => ({
            isDragging: !!monitor.isDragging(),
        }),
    });

    const label = "Title and Text"
    return (tile({isDragging, drag, label}));
};

const DraggableEmail = ({
                            sender = "John Doe",
                            subject = "Sample Email",
                            body = "This is a sample email body.",
                            date = "April 29, 2024"
                        }) => {
    const [{isDragging}, drag] = useDrag({
        type: 'component',
        item: {
            type: 'email',
            properties: {
                sender: [{input: 'text', value: sender}],
                subject: [{input: 'text', value: subject}],
                body: [{input: 'paragraph', value: body}],
                date: [{input: 'text', value: date}],
            },
        },
        collect: (monitor) => ({
            isDragging: !!monitor.isDragging(),
        }),
    });
    const label = "Email"
    return (tile({isDragging, drag, label}));
};

const DraggableSpacer = () => {
    const [{isDragging}, drag] = useDrag({
        type: 'component',
        item: {type: 'spacer', properties: {}},
        collect: (monitor) => ({
            isDragging: !!monitor.isDragging(),
        }),
    });
    const label = "Spacer"
    return (tile({isDragging, drag, label}));
};

const tile = ({isDragging, drag, label}) => {
    return (
        <div
            ref={drag}
            style={{
                opacity: isDragging ? 0.5 : 1,
                cursor: 'move',
                border: '1px solid #ccc', // Add a border
                borderRadius: '5px', // Add rounded corners
                padding: '10px', // Add padding for spacing
                backgroundColor: '#f0f0f0', // Set a background color
                boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)', // Add a shadow
                width: '100%', // Set width for the tile
                height: '100%', // Set height for the tile
                textAlign: "center"
            }}
        >
            {label}
        </div>

    );
};
export {DraggableFlipTile, DraggableText, DraggableTextTitle, DraggableEmail, DraggableSpacer};
