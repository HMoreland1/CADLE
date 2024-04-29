
import { createRoot } from 'react-dom/client';
import Editor from "@/Components/SCORM/Editor/Editor.jsx";



export function initializeCreator(rows) {
    const creatorContainer = document.getElementById("creator-container");
    let root = null
    if (creatorContainer) {
        console.log("creatorContainer: ", creatorContainer)
        root = createRoot(creatorContainer);
        console.log("root: ", root)
        if (root && creatorContainer) {
            root.render(<Editor startingRows={rows} isEditing={true} />);
        } else {

            console.log("No Container ", creatorContainer)
        }
    }



    return root;
}

// Function to unmount the component and remove the root



    // Add cleanup function to listen for Turbo visit events



