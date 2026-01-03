<?php
// Test URL access
$urls = [
    'http://localhost/usahain/',
    'http://localhost/usahain/auth/login',
    'http://localhost/usahain/auth/register',
];

foreach ($urls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "URL: $url\n";
    echo "HTTP Code: $httpCode\n";
    echo str_repeat("-", 50) . "\n";
}
