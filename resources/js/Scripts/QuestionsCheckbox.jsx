// Define the function to initialize the checkbox behavior
export function initializeQuestionsCheckbox(quizTotalMarks) {
    // Get all checkboxes
    const checkboxes = document.querySelectorAll('.question-checkbox');

    // Function to handle checkbox change
    function handleCheckboxChange() {
        const selectedCheckboxes = document.querySelectorAll('.question-checkbox:checked');
        if (selectedCheckboxes.length > quizTotalMarks) {
            // If the number of selected checkboxes exceeds the total marks, disable further selection
            checkboxes.forEach(function(checkbox) {
                if (!checkbox.checked) {
                    checkbox.disabled = true;
                }
            });
        } else {
            // Enable checkboxes
            checkboxes.forEach(function(checkbox) {
                checkbox.disabled = false;
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

document.addEventListener("turbo:load", function() {
    // Get the total marks of the quiz from a data attribute or any other method
    const quizTotalMarks = parseInt(document.querySelector('[data-quiz-total-marks]').dataset.quizTotalMarks);

    // Call the function to initialize checkbox behavior
    initializeQuestionsCheckbox(quizTotalMarks);
});
