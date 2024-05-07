import React, { useState } from 'react';
import './FlipTile.css';
import parse from "html-react-parser"; // Import the CSS file for styling

const FlipTile = ({ title, text }) => {
    const [isFlipped, setIsFlipped] = useState(false);

    const handleFlip = () => {
        setIsFlipped(!isFlipped);
    };

    const flipBtn = () => {
        return (
            <svg xmlns="http://www.w3.org/2000/svg" width="8%" height="8%" fill="currentColor"
                 className="bi bi-arrow-repeat" viewBox="0 0 16 16">
                <path
                    d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                <path
                      d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
            </svg>
        )
    }
    return (
        <div className={`tile ${isFlipped ? 'flipped' : ''}`} onClick={handleFlip}>
            <div className="tile-inner">
                <div className="tile-front">
                    <h2>{title[0].value}</h2>
                    {flipBtn()}
                </div>
                <div className="tile-back">
                    <div className="back-text" style={{textAlign: 'center'}}>{parse(text[0].value)}</div>
                    {flipBtn()}
                </div>
            </div>
        </div>
    );
};

export default FlipTile;
