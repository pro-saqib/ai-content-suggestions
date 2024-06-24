jQuery(document).ready(function($) {
    $('#analyze-content').on('click', function() {
        var content = $('#ai-content').val();
        if (content.length === 0) {
            alert('Please enter some content to analyze.');
            return;
        }

        // AJAX call to get AI suggestions
        $.ajax({
            url: aiContentSuggestions.ajax_url,
            method: 'POST',
            data: {
                action: 'ai_get_suggestions',
                content: content,
                nonce: aiContentSuggestions.nonce
            },
            success: function(response) {
                $('#ai-suggestions').html('<p>' + response + '</p>');
            },
            error: function() {
                $('#ai-suggestions').html('<p>There was an error processing your request.</p>');
            }
        });
    });
});
