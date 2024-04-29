import parse from 'html-react-parser';
import 'quill/dist/quill.snow.css';

import '../../../../../css/QuillConverted.css';

// DraggableText component renders a text element
const textTitle = ({ title, text, alignment}) => {
    const alignStyle = {
        textAlign: alignment[0].value // Use the alignment value to set textAlign
    };
    return (
        <div style={alignStyle}>
            <h1>{title[0].value}</h1>
            {parse(text[0].value)}
        </div>
    );
};

export default textTitle;
