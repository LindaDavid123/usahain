<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gemini {

    private $apiKey;
    private $endpoint;

    public function __construct()
    {
        // Get CI instance to access config
        $CI =& get_instance();
        
        // Force reload config setiap kali untuk memastikan API key terbaru
        $CI->config->load('gemini', TRUE, TRUE);
        
        // Try environment variable first, then config file
        $this->apiKey = getenv('GEMINI_API_KEY') ?: $CI->config->item('gemini_api_key', 'gemini');
        
        // Gunakan model gemini-2.5-flash (Updated: 2026-01-03 13:49)
        $this->endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent";

        log_message('debug', 'Gemini API key: '.($this->apiKey ? 'SET ('.strlen($this->apiKey).' chars)' : 'KOSONG'));
        log_message('info', 'Gemini library loaded with model: gemini-2.5-flash (API key first 10 chars: ' . substr($this->apiKey, 0, 10) . ')');
    }

    public function generate($prompt)
    {
        if (empty($this->apiKey)) {
            log_message('error', 'Gemini API key kosong');
            return null;
        }

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
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

        // Gemini API uses X-goog-api-key header (updated method)
        $headers = [
            'Content-Type: application/json',
            'X-goog-api-key: ' . $this->apiKey
        ];
        $url = $this->endpoint;

        // Retry mechanism for network issues
        $maxRetries = 2;
        $response = null;
        
        for ($attempt = 0; $attempt <= $maxRetries; $attempt++) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_TIMEOUT => 60,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification untuk XAMPP
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_DNS_CACHE_TIMEOUT => 120,
                CURLOPT_VERBOSE => false,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_errno($ch);
            $curlErrorMsg = curl_error($ch);
            
            if ($curlError) {
                curl_close($ch);
                
                if ($attempt < $maxRetries) {
                    log_message('info', "Gemini API attempt " . ($attempt + 1) . " failed (CURL error {$curlError}): {$curlErrorMsg}. Retrying...");
                    sleep(2); // Wait 2 seconds before retry
                    continue;
                } else {
                    log_message('error', 'Gemini CURL error after ' . ($maxRetries + 1) . ' attempts (CURL error {$curlError}): ' . $curlErrorMsg);
                    return null;
                }
            }
            
            curl_close($ch);
            
            // Handle specific HTTP error codes
            if ($httpCode == 429) {
                // Quota exceeded - log dan kembalikan null agar fallback digunakan
                $errorData = json_decode($response, true);
                $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Quota exceeded';
                log_message('error', "Gemini API Quota Exceeded (HTTP 429): {$errorMsg}");
                return null;
            } elseif ($httpCode == 403) {
                $errorData = json_decode($response, true);
                $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Access denied';
                log_message('error', "Gemini API Access Denied (HTTP 403): {$errorMsg}");
                log_message('debug', "Full 403 response: " . substr($response, 0, 1000));
                return null;
            } elseif ($httpCode == 400) {
                $errorData = json_decode($response, true);
                $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Bad request';
                log_message('error', "Gemini API Bad Request (HTTP 400): {$errorMsg}");
                return null;
            }
            
            // Success - break the retry loop
            if ($httpCode == 200) {
                log_message('debug', 'Gemini API success on attempt ' . ($attempt + 1) . ' with HTTP 200');
                break;
            } else {
                log_message('info', "Gemini API returned HTTP {$httpCode} on attempt " . ($attempt + 1) . ". Response: " . substr($response, 0, 500));
                if ($attempt < $maxRetries) {
                    sleep(2);
                }
            }
        }

        if (!$response) {
            log_message('error', 'Gemini API: No response after retries');
            return null;
        }

        // 🔥 LOG RESPONSE ASLI (SANGAT PENTING)
        log_message('debug', 'Gemini raw response: '.$response);

        $data = json_decode($response, true);

        // Try to extract text from known fields, then fallback to recursive search
        $text = $this->extract_text_from_response($data);
        if ($text !== null) {
            return trim($text);
        }

        // Log structured response to help debugging
        log_message('error', 'Gemini response invalid structure or empty. Raw: ' . substr($response, 0, 1000));
        return null;
    }

    // Try to extract text from a variety of possible response shapes
    private function extract_text_from_response($data)
    {
        if (!is_array($data)) return null;

        // Common older shape: candidates -> content -> parts -> text
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return $data['candidates'][0]['content']['parts'][0]['text'];
        }

        // Another shape: candidates -> text
        if (isset($data['candidates'][0]['text'])) {
            return $data['candidates'][0]['text'];
        }

        // Newer shapes may use outputs or output arrays
        if (isset($data['output'][0]['content'][0]['text'])) {
            return $data['output'][0]['content'][0]['text'];
        }
        if (isset($data['outputs'][0]['content'][0]['text'])) {
            return $data['outputs'][0]['content'][0]['text'];
        }

        // Recursive search for any 'text' key
        $stack = [$data];
        while (!empty($stack)) {
            $item = array_pop($stack);
            if (is_array($item)) {
                foreach ($item as $k => $v) {
                    if ($k === 'text' && is_string($v) && strlen(trim($v)) > 0) return $v;
                    if (is_array($v)) $stack[] = $v;
                }
            }
        }

        return null;
    }
}
