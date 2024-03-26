import Vvveb from 'vvvebjs';

    // Function to initialize VvvebJs editor
    function initializeVvvebEditor() {
    editor = Vvveb.Builder.init('#vvveb-editor');
}

    // Declare editor variable outside the functions to make it accessible globally
    let editor;

    // Function to open editor popup
    function openEditorPopup() {
    document.getElementById('editor-popup').style.display = 'block';
    initializeVvvebEditor(); // Initialize the VvvebJs editor
}

    // Function to close editor popup
    function closePopup() {
    document.getElementById('editor-popup').style.display = 'none';
}

    // Function to save content
    function saveContent() {
    const htmlContent = editor.html(); // Get HTML content from VvvebJs editor
    document.getElementById('learning_content_content').value = htmlContent; // Update textarea with HTML content
    closePopup(); // Close the popup

    // You can optionally submit the form or perform other actions here
        function Test() {
            console.log("test");
        }
}

