<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Google OAuth 2.0 Configuration
 *
 * Copy this file to 'google_oauth.php':
 *   cp google_oauth_sample.php google_oauth.php
 *
 * Setup Instructions:
 * 1. Go to https://console.cloud.google.com
 * 2. Create a new project or select existing project
 * 3. Enable Google+ API or Google OAuth2 API
 * 4. Go to Credentials → Create Credentials → OAuth 2.0 Client ID
 * 5. Application type: Web application
 * 6. Set Authorized redirect URIs:
 *    - http://localhost/usahain/googleauth/callback
 * 7. Copy Client ID and Client Secret to .env file
 * 8. For production, add your domain URL to Authorized redirect URIs
 */

// Load .env file jika ada (robust loading dengan fallback)
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

// Google OAuth Client ID (dari .env)
$config['google_client_id'] = trim(getenv('GOOGLE_CLIENT_ID') ?: '');

// Google OAuth Client Secret (dari .env)
$config['google_client_secret'] = trim(getenv('GOOGLE_CLIENT_SECRET') ?: '');

// Redirect URI setelah OAuth (harus sama dengan yang didaftarkan di Google Console)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base = rtrim($protocol . $host, '/');
$config['google_redirect_uri'] = $base . '/usahain/googleauth/callback';

// Scope yang diminta dari Google (profile, email)
$config['google_scopes'] = [
    'https://www.googleapis.com/auth/userinfo.profile',
    'https://www.googleapis.com/auth/userinfo.email'
];

// Application name
$config['google_application_name'] = 'Usahain App';

// Access type (online atau offline)
$config['google_access_type'] = 'online';

// Approval prompt
$config['google_approval_prompt'] = 'auto';

// Prompt parameter untuk force select account
$config['google_prompt'] = 'select_account';
