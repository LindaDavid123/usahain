<?php
/**
 * Test Gemini API dengan cara yang sama persis seperti di aplikasi
 */

// Load CI config untuk ambil API key
define('BASEPATH', true);
require_once 'application/config/gemini.php';

$apiKey = $config['gemini_api_key'];
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent";

echo "=== TEST FROM APP CONTEXT ===\n\n";
echo "API Key: " . substr($apiKey, 0, 20) . "... (" . strlen($apiKey) . " chars)\n";
echo "Endpoint: $endpoint\n\n";

$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Halo, berikan 1 tips singkat bisnis kuliner']
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

$headers = ['Content-Type: application/json'];
$url = $endpoint . '?key=' . urlencode($apiKey);

echo "Sending request...\n";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_TIMEOUT => 60,
    CURLOPT_CONNECTTIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_VERBOSE => false,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_errno($ch);
$curlErrorMsg = curl_error($ch);

curl_close($ch);

echo "\n--- RESULT ---\n";
echo "HTTP Code: $httpCode\n";

if ($curlError) {
    echo "CURL Error ($curlError): $curlErrorMsg\n";
    exit(1);
}

if ($httpCode !== 200) {
    echo "\nERROR Response:\n";
    echo $response . "\n";
    exit(1);
}

$data = json_decode($response, true);
if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
    echo "\n✅ SUCCESS!\n";
    echo "Response: " . $data['candidates'][0]['content']['parts'][0]['text'] . "\n";
} else {
    echo "\n❌ No text in response\n";
    print_r($data);
}
