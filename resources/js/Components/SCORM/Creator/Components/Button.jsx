import React from 'react';

const Button = ({ text, color, style }) => {


    return (
        <div
            className="button"
            style={{
                height: '100%',
                width: ' 100%',
                backgroundColor: '#f1f1f1',
                color: 'black',
            }}
        >
            {text || 'Button'} {/* Default text is 'Button' */}
        </div>
    );
};

export default Button;
