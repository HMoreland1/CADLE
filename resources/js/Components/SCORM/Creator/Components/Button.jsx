import React from 'react';
const Button = ({ text, color, style }) => {

    return (
        <div
            className="button"
            style={{
                cursor: 'move',
                backgroundColor: color || 'blue', // Default color is blue
                height: '100%',
                width: ' 100%'
            }}
        >
            {text || 'Button'} {/* Default text is 'Button' */}
        </div>
    );
};

export default Button;
