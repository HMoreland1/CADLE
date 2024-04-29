<!-- Include the external JavaScript file -->


<!-- Initialize the script -->
<script type="module">
    import { initializeQuestionsCheckbox } from "{{ Vite::asset('resources/js/Scripts/QuestionsCheckbox.jsx') }}";

    document.addEventListener("DOMContentLoaded", function() {
        // Get the total marks of the quiz
        const quizTotalMarks = parseInt(<?php echo json_encode($quizTotalMarks); ?>-1);

        // Call the function from the external JavaScript file, passing the total marks
        initializeQuestionsCheckbox(quizTotalMarks);
    });
</script>
