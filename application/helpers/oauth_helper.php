<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * OAuth Helper Functions
 * 
 * Helper functions untuk OAuth operations
 */

if (!function_exists('is_oauth_user')) {
    /**
     * Check if current user logged in via OAuth
     * 
     * @return bool
     */
    function is_oauth_user()
    {
        $CI =& get_instance();
        $provider = $CI->session->userdata('oauth_provider');
        return $provider && $provider !== 'local';
    }
}

if (!function_exists('get_user_avatar')) {
    /**
     * Get user avatar URL or default avatar
     * 
     * @param string|null $avatar_url
     * @return string
     */
    function get_user_avatar($avatar_url = null)
    {
        if ($avatar_url) {
            return $avatar_url;
        }
        
        $CI =& get_instance();
        $avatar = $CI->session->userdata('avatar_url');
        
        if ($avatar) {
            return $avatar;
        }
        
        // Return default avatar
        return base_url('assets/images/default-avatar.png');
    }
}

if (!function_exists('require_oauth_setup')) {
    /**
     * Check if Google OAuth is properly configured
     * 
     * @return bool
     */
    function is_oauth_configured()
    {
        $CI =& get_instance();
        $CI->load->config('google_oauth');
        
        $client_id = $CI->config->item('google_client_id');
        $client_secret = $CI->config->item('google_client_secret');
        
        return !empty($client_id) && !empty($client_secret);
    }
}

if (!function_exists('get_oauth_provider_name')) {
    /**
     * Get friendly name of OAuth provider
     * 
     * @param string $provider
     * @return string
     */
    function get_oauth_provider_name($provider)
    {
        $providers = [
            'local' => 'Email/Password',
            'google' => 'Google'
        ];
        
        return isset($providers[$provider]) ? $providers[$provider] : ucfirst($provider);
    }
}
