<!-- Include the external JavaScript file -->


<!-- Initialize the script -->
<script type="module">
    import { initializeContentQuizCheckbox } from "{{ Vite::asset('resources/js/Scripts/ContentQuizCheckbox.jsx') }}";

    document.addEventListener("DOMContentLoaded", function() {
        // Check if the element with class content-quiz-checkbox exists on the current page
        const quizElement = document.querySelector('.content-quiz-checkbox');
        if (quizElement) {
            // Call the function to initialize checkbox behavior
            initializeContentQuizCheckbox();
        }
    });

</script>
