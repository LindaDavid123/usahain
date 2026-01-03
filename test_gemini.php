<?php
// Test script untuk Gemini API
putenv('GEMINI_API_KEY=AIzaSyAcszB8hqeyB1bmnk-z5oTN5LVEuRP_gIo');

$apiKey = getenv('GEMINI_API_KEY');
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent";

$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Berikan saran singkat untuk usaha kuliner dengan modal 10 juta di Jakarta']
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

$url = $endpoint . '?key=' . urlencode($apiKey);
$headers = ['Content-Type: application/json'];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_TIMEOUT => 45,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "CURL Error: " . curl_error($ch) . "\n";
} else {
    echo "HTTP Code: " . $httpCode . "\n";
    $data = json_decode($response, true);
    
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        echo "\n✅ SUCCESS! AI Response:\n";
        echo $data['candidates'][0]['content']['parts'][0]['text'] . "\n";
    } else {
        echo "\nResponse:\n";
        print_r($data);
    }
}

curl_close($ch);
