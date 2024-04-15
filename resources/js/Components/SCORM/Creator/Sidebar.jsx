import React, { Component } from 'react';
import SidebarComponent from "@/Components/SCORM/Creator/SidebarComponent.jsx";

class Sidebar extends Component {
    render() {
        const { components } = this.props;

        return (
            <div className="sidebar">
                {components.map((componentObj, index) => (
                    <SidebarComponent key={index} componentObj={componentObj} />
                ))}
            </div>
        );
    }
}

export default Sidebar;
