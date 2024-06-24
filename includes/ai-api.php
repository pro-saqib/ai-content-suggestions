<?php

function call_ai_service($content) {
    $api_key = 'YOUR_API_KEY';
    $url = 'https://api.openai.com/v1/engines/davinci-codex/completions';

    $response = wp_remote_post($url, array(
        'body' => json_encode(array(
            'prompt' => $content,
            'max_tokens' => 100,
            'temperature' => 0.7,
        )),
        'headers' => array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $api_key,
        ),
    ));

    if (is_wp_error($response)) {
        error_log('Error connecting to AI service: ' . $response->get_error_message());
        return 'Error connecting to AI service';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['choices']) && is_array($data['choices']) && isset($data['choices'][0]['text'])) {
        return $data['choices'][0]['text'];
    } else {
        error_log('Unexpected response from AI service: ' . $body);
        return 'Unexpected response from AI service';
    }
}

?>
