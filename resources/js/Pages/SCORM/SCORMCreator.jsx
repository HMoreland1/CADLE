// resources/js/Pages/SCORMCreator.jsx
import Editor from "@/Components/SCORM/Editor/Editor.jsx";
const SCORMCreator = (baseContent) => {
    return (
        <div className="scorm-creator">
            <div className="editor-container">
                <Editor startingRows={baseContent}></Editor>
            </div>
        </div>
    );
};

export default SCORMCreator;
