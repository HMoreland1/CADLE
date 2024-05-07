<!-- Include the external JavaScript file -->


<!-- Initialize the script -->
<script type="module">
    import { initializeQuestionsCheckbox } from "{{ Vite::asset('resources/js/Scripts/QuestionsCheckbox.jsx') }}";

    document.addEventListener("turbo:load", function() {
        // Call the function from the external JavaScript file, passing the total marks
        initializeQuestionsCheckbox({!! $quizTotalMarks - 1!!});
    });
    document.addEventListener("DOMContentLoaded", function() {
        // Call the function from the external JavaScript file, passing the total marks
        initializeQuestionsCheckbox({!! $quizTotalMarks - 1!!});
    });
</script>
