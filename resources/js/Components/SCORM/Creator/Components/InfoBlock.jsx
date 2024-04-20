import React, { Component } from 'react';

class InfoBlock extends Component {
    constructor(props) {
        super(props);
        this.state = {
            title: props.title,
            text: props.text
        };
    }

    render() {
        const { title, text } = this.state;

        return (
            <div className="info-block">
                <div className="title">{title}</div>
                <p className="text">{text}</p>
            </div>
        );
    }
}

export default InfoBlock;
