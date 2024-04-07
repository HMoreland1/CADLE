import React from 'react';

const InfoBlock = ({ title = 'Lorem Ipsum Title', text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' }) => {
    return (
        <div className="info-block">
            <h2>{title}</h2>
            <p>{text}</p>
        </div>
    );
};

export default InfoBlock;
