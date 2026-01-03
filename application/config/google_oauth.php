<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Google OAuth 2.0 Configuration
 * 
 * Setup Instructions:
 * 1. Go to https://console.cloud.google.com
 * 2. Create a new project or select existing project
 * 3. Enable Google+ API
 * 4. Go to Credentials → Create Credentials → OAuth 2.0 Client ID
 * 5. Set Authorized redirect URIs: http://localhost/usahain/googleauth/callback
 * 6. Copy Client ID and Client Secret to this file
 * 7. For production, add your domain URL to Authorized redirect URIs
 */

// Google OAuth Client ID (dari Google Cloud Console)
$config['google_client_id'] = getenv('GOOGLE_CLIENT_ID') ?: '';

// Google OAuth Client Secret (dari Google Cloud Console)
$config['google_client_secret'] = getenv('GOOGLE_CLIENT_SECRET') ?: '';

// Redirect URI setelah OAuth (harus sama dengan yang didaftarkan di Google Console)
$config['google_redirect_uri'] = base_url('googleauth/callback');

// Scope yang diminta dari Google (profile, email)
$config['google_scopes'] = [
    'https://www.googleapis.com/auth/userinfo.profile',
    'https://www.googleapis.com/auth/userinfo.email'
];

// Application name
$config['google_application_name'] = 'Usahain App';

// Access type (online atau offline)
$config['google_access_type'] = 'online';

// Approval prompt (auto atau force)
$config['google_approval_prompt'] = 'auto';
