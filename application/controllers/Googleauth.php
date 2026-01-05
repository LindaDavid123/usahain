<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Google OAuth 2.0 Authentication Controller
 *
 * Handles:
 * - Redirect to Google login page
 * - Callback from Google with authorization code
 * - Exchange code for access token
 * - Get user profile from Google
 * - Create/update user in database
 * - Set session for logged in user
 */
class Googleauth extends CI_Controller
{

    private $google_client;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->config('google_oauth');
        $this->load->helper(['url', 'cookie']);

        // Initialize Google Client
        $this->_init_google_client();
    }

    /**
     * Initialize Google OAuth Client
     */
    private function _init_google_client()
    {
        // Load autoloader from composer
        require_once FCPATH . 'vendor/autoload.php';

        // Get credentials from config
        $client_id     = $this->config->item('google_client_id');
        $client_secret = $this->config->item('google_client_secret');

        // Validate credentials are set
        if (empty($client_id) || empty($client_secret)) {
            log_message('error', 'Google OAuth credentials not configured');
            return false;
        }

        $this->google_client = new Google_Client();
        $this->google_client->setClientId($client_id);
        $this->google_client->setClientSecret($client_secret);
        $this->google_client->setRedirectUri($this->config->item('google_redirect_uri'));
        $this->google_client->setScopes($this->config->item('google_scopes'));
        $this->google_client->setAccessType($this->config->item('google_access_type'));
        $this->google_client->setApprovalPrompt($this->config->item('google_approval_prompt'));

        // Force account selection on every login (no auto-login)
        // This will display Google Account Picker
        $this->google_client->setPrompt('select_account');

        return true;
    }

    /**
     * Redirect user to Google OAuth consent screen
     */
    public function login()
    {
        // Check if OAuth is configured
        if (! $this->google_client) {
            $this->session->set_flashdata('error',
                'Google OAuth belum dikonfigurasi. Silakan hubungi administrator.<br>' .
                '<small>Setup: Edit file .env dan tambahkan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET</small>');
            redirect('auth/login');
            return;
        }

        // Save redirect parameter to session if provided
        $redirect = $this->input->get('redirect');
        if ($redirect) {
            $this->session->set_userdata('oauth_redirect', $redirect);
        }

        // Create state token to prevent CSRF
        $state = bin2hex(random_bytes(16));
        $this->session->set_userdata('oauth_state', $state);
        $this->google_client->setState($state);

        // Generate and redirect to auth URL
        $auth_url = $this->google_client->createAuthUrl();
        redirect($auth_url);
    }

    /**
     * Handle callback from Google after user authorization
     */
    public function callback()
    {
        // Verify state to prevent CSRF
        $state         = $this->input->get('state');
        $session_state = $this->session->userdata('oauth_state');

        if (! $state || $state !== $session_state) {
            $this->session->set_flashdata('error', 'Invalid state parameter. Possible CSRF attack.');
            redirect('auth/login');
            return;
        }

        // Clear state from session
        $this->session->unset_userdata('oauth_state');

        // Check for error from Google
        if ($this->input->get('error')) {
            $this->session->set_flashdata('error', 'Google authentication cancelled or failed.');
            redirect('auth/login');
            return;
        }

        // Get authorization code
        $code = $this->input->get('code');
        if (! $code) {
            $this->session->set_flashdata('error', 'No authorization code received from Google.');
            redirect('auth/login');
            return;
        }

        try {
            // Exchange authorization code for access token
            $token = $this->google_client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                log_message('error', 'Google OAuth Error: ' . print_r($token, true));
                $this->session->set_flashdata('error', 'Failed to authenticate with Google.');
                redirect('auth/login');
                return;
            }

            // Set access token
            $this->google_client->setAccessToken($token);

            // Get user profile information
            $google_oauth        = new Google_Service_Oauth2($this->google_client);
            $google_account_info = $google_oauth->userinfo->get();

            // Extract user data
            $google_id = $google_account_info->id;
            $email     = $google_account_info->email;
            $name      = $google_account_info->name;
            $picture   = $google_account_info->picture;

            // Check if user exists by google_id
            $user = $this->Auth_model->get_user_by_google_id($google_id);

            if ($user) {
                // User exists, update last login and avatar
                $update_data = [
                    'avatar_url' => $picture,
                ];
                $this->Auth_model->update_user($user->id_user, $update_data);

            } else {
                // Check if email already exists (local account)
                $existing_user = $this->Auth_model->get_user_by_email($email);

                if ($existing_user) {
                    // Link Google account to existing local account
                    $update_data = [
                        'google_id'      => $google_id,
                        'oauth_provider' => 'google',
                        'avatar_url'     => $picture,
                    ];
                    $this->Auth_model->update_user($existing_user->id_user, $update_data);
                    $user = $this->Auth_model->get_user_by_email($email);

                } else {
                    // Create new user
                    $user_data = [
                        'google_id'      => $google_id,
                        'oauth_provider' => 'google',
                        'nama'           => $name,
                        'email'          => $email,
                        'avatar_url'     => $picture,
                        'password'       => null, // OAuth users don't have password
                        'role'           => 'user',
                    ];

                    $user_id = $this->Auth_model->create_user($user_data);
                    $user    = $this->Auth_model->get_user_by_id($user_id);
                }
            }

            // Set session for logged in user
            $this->session->set_userdata([
                'id_user'        => $user->id_user,
                'nama'           => $user->nama,
                'email'          => $user->email,
                'role'           => $user->role,
                'avatar_url'     => $user->avatar_url,
                'oauth_provider' => $user->oauth_provider,
                'logged_in'      => true,
            ]);

            // Log successful login
            log_message('info', 'User logged in via Google OAuth: ' . $email);

            // Check if there's a redirect URL stored in session
            $redirect_url = $this->session->userdata('oauth_redirect');
            if ($redirect_url) {
                $this->session->unset_userdata('oauth_redirect');
                redirect($redirect_url);
                return;
            }

            // Redirect based on role
            if ($user->role === 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('auth/dashboard');
            }

        } catch (Exception $e) {
            log_message('error', 'Google OAuth Exception: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred during Google authentication.');
            redirect('auth/login');
        }
    }

    /**
     * Logout and revoke Google access (optional)
     */
    public function logout()
    {
        // Optional: Revoke access token
        if ($this->session->userdata('oauth_provider') === 'google') {
            try {
                $this->google_client->revokeToken();
            } catch (Exception $e) {
                log_message('warning', 'Failed to revoke Google token: ' . $e->getMessage());
            }
        }

        // Destroy session
        $this->session->sess_destroy();

        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        redirect('auth/login');
    }
}
