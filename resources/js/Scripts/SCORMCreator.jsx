// CreatorContainer.jsx
import ReactDOM from 'react-dom/client';
import VisualEditor from "@/Components/SCORM/Creator/VisualEditor.jsx";

export function initializeCreator() {
        // Get the element with id "creator-container"
        console.log("test")
        const creatorContainer = document.getElementById("creator-container");

        // Render VisualEditor component into the "creator-container"
        if (creatorContainer) {
            const root= ReactDOM.createRoot(creatorContainer)
            root.render(<VisualEditor/>);
        }


    return null; // or you can return some placeholder content here
}

document.addEventListener("turbo:load", function() {
    // Get the total marks of the quiz from a data attribute or any other method
    // Call the function to initialize checkbox behavior
    initializeCreator();
});
