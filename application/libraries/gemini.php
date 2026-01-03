<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gemini {

    private $apiKey;
    private $endpoint;

    public function __construct()
    {
        $this->apiKey = getenv('GEMINI_API_KEY');
        $this->endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent";

        log_message('debug', 'Gemini API key: '.($this->apiKey ? 'ADA' : 'KOSONG'));
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

        // Gemini API uses key as query parameter, NOT Bearer token
        $headers = ['Content-Type: application/json'];
        if (!empty($this->apiKey)) {
            $url = $this->endpoint . '?key=' . urlencode($this->apiKey);
        } else {
            $url = $this->endpoint;
        }

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
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_DNS_CACHE_TIMEOUT => 120,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                $error = curl_error($ch);
                curl_close($ch);
                
                if ($attempt < $maxRetries) {
                    log_message('warning', "Gemini API attempt " . ($attempt + 1) . " failed: {$error}. Retrying...");
                    sleep(1); // Wait 1 second before retry
                    continue;
                } else {
                    log_message('error', 'Gemini CURL error after ' . ($maxRetries + 1) . ' attempts: ' . $error);
                    return null;
                }
            }
            
            curl_close($ch);
            
            // Success - break the retry loop
            if ($httpCode == 200) {
                break;
            } else {
                log_message('warning', "Gemini API returned HTTP {$httpCode} on attempt " . ($attempt + 1));
                if ($attempt < $maxRetries) {
                    sleep(1);
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
