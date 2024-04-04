import React from 'react';

const ProgressBar = ({ percentage }) => {
    // Ensure percentage is within 0 to 100
    const normalizedPercentage = Math.min(100, Math.max(0, percentage));

    // Style for the progress bar
    const progressBarStyle = {
        width: `${normalizedPercentage}%`,
        height: '20px',
        backgroundColor: '#4CAF50',
        borderRadius: '4px',
    };

    return (
        <div>
            <div  style={{ border: '1px solid #ccc', borderRadius: '4px' }}>
                <div style={progressBarStyle}></div>
            </div>
            <p style={{ marginTop: '5px' }}>{`${normalizedPercentage}%`}</p>
        </div>
    );
};

export default ProgressBar;
