<?php
/**
 * List available Gemini models
 */

$apiKey = 'AIzaSyDGtPd3B5m5PJtWUHbd8mZzpiWCpduNELg';
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models";

echo "=== LIST GEMINI MODELS ===\n\n";

$url = $endpoint . '?key=' . urlencode($apiKey);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n\n";

if ($httpCode !== 200) {
    echo "Error:\n";
    echo $response . "\n";
    exit(1);
}

$data = json_decode($response, true);

if (!isset($data['models'])) {
    echo "No models found\n";
    exit(1);
}

echo "Available models that support generateContent:\n";
echo str_repeat("-", 80) . "\n";

foreach ($data['models'] as $model) {
    $name = $model['name'] ?? 'unknown';
    $supportedMethods = $model['supportedGenerationMethods'] ?? [];
    
    // Only show models that support generateContent
    if (in_array('generateContent', $supportedMethods)) {
        echo "✓ " . $name . "\n";
        if (isset($model['displayName'])) {
            echo "  Display: " . $model['displayName'] . "\n";
        }
        if (isset($model['description'])) {
            echo "  " . substr($model['description'], 0, 100) . "...\n";
        }
        echo "\n";
    }
}

echo str_repeat("-", 80) . "\n";
echo "Done\n";
