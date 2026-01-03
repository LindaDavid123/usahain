<?php
/**
 * Test script untuk verify Gemini API berfungsi dengan baik
 * Jalankan: php test_gemini_fix.php
 */

// API Key dari config
$apiKey = 'AIzaSyAqzIj41nbJeBCYx0JwL7G8y211R_qZGHg';
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent";

echo "=== TEST GEMINI API CONNECTION ===\n\n";
echo "Endpoint: $endpoint\n";
echo "API Key: " . substr($apiKey, 0, 20) . "... (" . strlen($apiKey) . " chars)\n\n";

$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Berikan satu saran bisnis untuk modal 10 juta rupiah di kota besar. Maksimal 50 kata.']
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

$url = $endpoint;
$headers = [
    'Content-Type: application/json',
    'X-goog-api-key: ' . $apiKey
];

echo "Mengirim request ke Gemini API...\n";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_TIMEOUT => 60,
    CURLOPT_CONNECTTIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_VERBOSE => false,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_errno($ch);
$curlErrorMsg = curl_error($ch);

curl_close($ch);

echo "\n--- HASIL ---\n";
echo "HTTP Code: $httpCode\n";

if ($curlError) {
    echo "CURL Error ($curlError): $curlErrorMsg\n";
    exit(1);
}

echo "Response Length: " . strlen($response) . " bytes\n\n";

if ($httpCode !== 200) {
    echo "ERROR: HTTP Code bukan 200\n";
    echo "Response:\n";
    echo $response . "\n";
    exit(1);
}

$data = json_decode($response, true);

if (!$data) {
    echo "ERROR: Response bukan JSON valid\n";
    echo "Response:\n";
    echo $response . "\n";
    exit(1);
}

echo "JSON Structure:\n";
print_r($data);
echo "\n";

// Extract text
$text = null;
if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
    $text = $data['candidates'][0]['content']['parts'][0]['text'];
}

if ($text) {
    echo "\n✅ SUCCESS - Gemini API berfungsi!\n";
    echo "Response dari AI:\n";
    echo "---\n";
    echo trim($text) . "\n";
    echo "---\n";
} else {
    echo "\n❌ GAGAL - Text tidak ditemukan dalam response\n";
    exit(1);
}

echo "\n=== TEST SELESAI ===\n";
