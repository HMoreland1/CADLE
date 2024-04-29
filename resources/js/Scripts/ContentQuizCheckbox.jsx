export function initializeContentQuizCheckbox() {
    // Get all checkboxes
    const checkboxes = document.querySelectorAll('.content-quiz-checkbox');

    // Function to handle checkbox change
    function handleCheckboxChange() {
        const checkedCheckbox = document.querySelector('.content-quiz-checkbox:checked');

        checkboxes.forEach(function(checkbox) {
            checkbox.disabled = false; // Enable all checkboxes first
        });

        if (checkedCheckbox) {
            checkboxes.forEach(function(checkbox) {
                if (checkbox !== checkedCheckbox) {
                    checkbox.disabled = true; // Disable other checkboxes if one is checked
                }
            });
        }
    }

    // Attach event listeners to checkboxes
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', handleCheckboxChange);
    });

    // Call the handleCheckboxChange function initially
    handleCheckboxChange();
}

document.addEventListener("turbo:load ", function() {
    // Check if the element with class content-quiz-checkbox exists on the current page
    const quizElement = document.querySelector('.content-quiz-checkbox');
    console.log(quizElement)
    if (quizElement) {

        // Call the function to initialize checkbox behavior
        initializeContentQuizCheckbox();
    }
});
document.addEventListener("turbo:render", function() {
    // Check if the element with class content-quiz-checkbox exists on the current page
    const quizElement = document.querySelector('.content-quiz-checkbox');
    if (quizElement) {
        // Call the function to initialize checkbox behavior
        initializeContentQuizCheckbox();
    }
});
