<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| MIDTRANS PAYMENT GATEWAY SETTINGS
| -------------------------------------------------------------------
| This file contains the configuration for Midtrans payment gateway.
| 
| Copy this file to 'midtrans.php' and fill in your credentials.
| Make sure to add 'midtrans.php' to your .gitignore file.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['server_key']     Your Midtrans Server Key
|	['client_key']     Your Midtrans Client Key
|	['is_production']  Set to TRUE for production, FALSE for sandbox
|	['is_sanitized']   Enable/disable input sanitization
|	['is_3ds']         Enable/disable 3D Secure
|
*/

$config['midtrans_server_key'] = 'YOUR_MIDTRANS_SERVER_KEY_HERE';
$config['midtrans_client_key'] = 'YOUR_MIDTRANS_CLIENT_KEY_HERE'; // Optional
$config['midtrans_is_production'] = FALSE; // Set to TRUE for production
$config['midtrans_is_sanitized'] = TRUE;
$config['midtrans_is_3ds'] = TRUE;
