
// DraggableText component renders a text element
const DraggableText = ({ text, alignment }) => {
    const alignStyle = {
        textAlign: alignment[0].value // Use the alignment value to set textAlign
    };

    return <div style={alignStyle}>{text[0].value}</div>;
};

export default DraggableText;
