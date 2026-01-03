<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Gemini / Generative API configuration
// You can set these via environment variables (recommended) or edit here.
// Example (Windows PowerShell):
//   setx GEMINI_API_KEY "your_api_key_here"
//   setx GEMINI_ENDPOINT "https://generativelanguage.googleapis.com/v1beta2/models/text-bison-001:generate"

$config['gemini_api_key'] = getenv('GEMINI_API_KEY') ?: '';
$config['gemini_endpoint'] = getenv('GEMINI_ENDPOINT') ?: '';

// optional: default temperature for generation
$config['gemini_temperature'] = 0.2;
