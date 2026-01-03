<?php
// Simple test to check send_message endpoint
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simulate POST request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['id'] = '1'; // Change this to your advisor ID
$_POST['message'] = 'Test pesan, berikan saran singkat';

// Include CodeIgniter
require_once 'index.php';
