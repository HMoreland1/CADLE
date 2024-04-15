import React from 'react';
import ReactDOM from 'react-dom';
import SCORMCreator from 'resources/js/Pages/SCORM/SCORMCreator.jsx';
export default class extends window.Controller {
    connect() {
        // Create a React element for SCORMCreator
        const scormCreatorElement = React.createElement(SCORMCreator);

        // Render the React element into the DOM element associated with this controller
        ReactDOM.render(scormCreatorElement, this.element);
    }

    disconnect() {
        // Unmount the React component when the controller is disconnected
        ReactDOM.unmountComponentAtNode(this.element);
    }
}
