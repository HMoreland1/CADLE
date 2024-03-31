// public/js/search.js

function searchQuizzes() {
    var searchQuery = $('#search').val();
    $.ajax({
        url: window.searchQuizzes,
        type: 'GET',
        data: {
            search: searchQuery
        },
        success: function(response) {
            $('#quizzes-table').html(response);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}
