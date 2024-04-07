// resources/js/Pages/SCORMCreator.jsx
import React from 'react';
import { Link } from '@inertiajs/react';

import PropertyEditor from '@/Components/SCORM/Creator/PropertyEditor.jsx';
import VisualEditor from "@/Components/SCORM/Creator/VisualEditor.jsx";

const SCORMCreator = ({}) => {
    return (
        <div className="scorm-creator">
            <div className="header" style={{height: '5vh'}}>
                <h1>SCORM Creator</h1>
                <Link href="/">Back to Dashboard</Link>
            </div>
            <div className="editor-container" style={{height: '95vh'}}>
                <VisualEditor></VisualEditor>
            </div>
        </div>
    );
};

export default SCORMCreator;
