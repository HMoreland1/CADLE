const SaveLoad = ({ onSave, onLoad }) => {
    return (
        <div className="save-load">
            <button onClick={onSave}>Save</button>
            <button onClick={onLoad}>Load</button>
        </div>
    );
};

export default SaveLoad;
