const ColorPicker = ({ value, onChange }) => {
    const handleChange = (event) => {
        onChange(event.target.value);
    };

    return (
        <div className="color-picker">
            <input type="color" value={value} onChange={handleChange} />
        </div>
    );
};

export default ColorPicker;
