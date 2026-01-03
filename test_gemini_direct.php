<?php
// Test Gemini API directly - LIST MODELS first
$api_key = 'AIzaSyDGtPd3B5m5PJtWUHbd8mZzpiWCpduNELg';
$list_url = 'https://generativelanguage.googleapis.com/v1beta/models?key=' . urlencode($api_key);

echo "Listing available models...\n\n";

$ch = curl_init($list_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "Available models:\n";
    foreach ($data['models'] as $model) {
        if (strpos($model['name'], 'gemini') !== false) {
            echo "- " . $model['name'] . "\n";
            if (isset($model['supportedGenerationMethods'])) {
                echo "  Methods: " . implode(', ', $model['supportedGenerationMethods']) . "\n";
            }
        }
    }
} else {
    echo "Error listing models: " . $response . "\n";
}
curl_close($ch);

echo "\n\n---\n\nNow testing generateContent...\n\n";

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . urlencode($api_key);

$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Berikan 3 saran bisnis untuk modal 5 juta rupiah. Jawab dalam bahasa Indonesia dengan format markdown.']
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 1.0,
        'topP' => 0.95,
        'topK' => 40,
        'maxOutputTokens' => 1024
    ]
];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => true,
]);

echo "Testing Gemini API...\n\n";
echo "URL: " . substr($url, 0, 100) . "...\n\n";

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "CURL ERROR: " . curl_error($ch) . "\n";
} else {
    echo "HTTP Code: " . $httpCode . "\n\n";
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        echo "SUCCESS!\n\n";
        echo "Raw Response (first 500 chars):\n";
        echo substr($response, 0, 500) . "\n\n";
        
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            echo "Extracted Text:\n";
            echo $data['candidates'][0]['content']['parts'][0]['text'] . "\n";
        } else {
            echo "Could not find text in response\n";
            echo "Full response:\n";
            print_r($data);
        }
    } else {
        echo "API ERROR!\n";
        echo "Response: " . $response . "\n";
    }
}

curl_close($ch);
