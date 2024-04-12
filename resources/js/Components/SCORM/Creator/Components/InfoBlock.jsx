import React, { Component } from 'react';

class InfoBlock extends Component {
    constructor(props) {
        super(props);
        this.state = {
            title: props.title,
            text: props.text
        };
    }

    // Function to handle changes in title input
    handleTitleChange = (e) => {
        this.setState({ title: e.target.value });
    };

    // Function to handle changes in text input
    handleTextChange = (e) => {
        this.setState({ text: e.target.value });
    };

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
