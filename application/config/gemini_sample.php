<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Gemini / Generative API configuration
//
// Copy this file to 'gemini.php':
//   cp gemini_sample.php gemini.php
//
// Set your API key in .env:
//   GEMINI_API_KEY=your_api_key_here
//
// Get your API key from: https://aistudio.google.com/app/apikey

// Load .env file jika ada
$env_file = null;
if (file_exists(FCPATH . '.env')) {
    $env_file = FCPATH . '.env';
} elseif (file_exists(dirname(FCPATH) . '/.env')) {
    $env_file = dirname(FCPATH) . '/.env';
}

if ($env_file && file_exists($env_file)) {
    $env_contents = file_get_contents($env_file);
    $env_lines = array_filter(explode("\n", $env_contents));
    foreach ($env_lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, '" \'');
            if (!empty($key)) {
                putenv($key . '=' . $value);
            }
        }
    }
}

$config['gemini_api_key'] = getenv('GEMINI_API_KEY') ?: '';
$config['gemini_endpoint'] = getenv('GEMINI_ENDPOINT') ?: '';

// optional: default temperature for generation
$config['gemini_temperature'] = 0.2;
