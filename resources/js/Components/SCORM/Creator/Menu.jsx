import React from 'react';

const Menu = ({ onSave }) => {
    return (
        <div className="menu" style={{ height: '100%' }}>
            <button onClick={onSave}>Save</button> {/* Call onSave function when Save button is clicked */}
        </div>
    );
};

export default Menu;
