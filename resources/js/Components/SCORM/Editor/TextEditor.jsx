const TextEditor = ({ value, onChange }) => {
    const handleChange = (event) => {
        onChange(event.target.value);
    };

    return (
        <div className="text-editor">
            <textarea value={value} onChange={handleChange} />
        </div>
    );
};

export default TextEditor;
