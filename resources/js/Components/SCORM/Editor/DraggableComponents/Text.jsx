
// DraggableText component renders a text element
import parse from "html-react-parser";

const DraggableText = ({ text, alignment }) => {
    const alignStyle = {
        textAlign: alignment[0].value // Use the alignment value to set textAlign
    };

    return <div style={alignStyle}>{parse(text[0].value)}</div>;
};

export default DraggableText;
