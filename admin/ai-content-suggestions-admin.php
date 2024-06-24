<div class="wrap">
    <h1>AI-Powered Content Suggestions</h1>
    <form method="post" action="">
        <textarea name="content" rows="10" cols="50" placeholder="Enter your content here..."></textarea>
        <br>
        <input type="submit" name="analyze_content" value="Analyze Content" class="button button-primary">
    </form>
    <?php
    if (isset($_POST['analyze_content'])) {
        $content = sanitize_text_field($_POST['content']);
        $suggestions = call_ai_service($content);
        echo '<h2>Suggestions:</h2>';
        echo '<p>' . esc_html($suggestions) . '</p>';
    }
    ?>
</div>
