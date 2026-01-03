<?php
// Test what URLs are being generated
$html = file_get_contents('http://localhost/usahain/');

// Extract login link
if (preg_match('/href="([^"]*auth\/login[^"]*)"/', $html, $matches)) {
    echo "Login URL found: " . $matches[1] . "\n";
} else {
    echo "Login URL NOT found\n";
}

// Extract register link
if (preg_match('/href="([^"]*auth\/register[^"]*)"/', $html, $matches)) {
    echo "Register URL found: " . $matches[1] . "\n";
} else {
    echo "Register URL NOT found\n";
}

// Test if links work
echo "\n--- Testing Links ---\n";
$testUrls = [
    'http://localhost/usahain/auth/login',
    'http://localhost/usahain/index.php/auth/login',
    'http://localhost/usahain/auth/register',
    'http://localhost/usahain/index.php/auth/register',
];

foreach ($testUrls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $hasTitle = strpos($response, '<title>') !== false;
    echo sprintf("%-50s HTTP: %d  Has Title: %s\n", 
        $url, 
        $httpCode, 
        $hasTitle ? 'YES' : 'NO'
    );
}
