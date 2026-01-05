<?php
// Test Midtrans Configuration
define('BASEPATH', true);
require_once 'application/third_party/Midtrans.php';

echo "<h2>Midtrans Configuration Test</h2>";
echo "<pre>";

// Load config manually
$config = [];
include 'application/config/midtrans.php';

echo "Server Key: " . $config['midtrans_server_key'] . "\n";
echo "Client Key: " . $config['midtrans_client_key'] . "\n";
echo "Is Production: " . ($config['midtrans_is_production'] ? 'Yes' : 'No') . "\n";
echo "\n";

// Configure Midtrans
\Midtrans\Config::$serverKey    = $config['midtrans_server_key'];
\Midtrans\Config::$isProduction = $config['midtrans_is_production'];
\Midtrans\Config::$isSanitized  = $config['midtrans_is_sanitized'];
\Midtrans\Config::$is3ds        = $config['midtrans_is_3ds'];

echo "Midtrans Config Set:\n";
echo "Server Key: " . \Midtrans\Config::$serverKey . "\n";
echo "Is Production: " . (\Midtrans\Config::$isProduction ? 'Yes' : 'No') . "\n";
echo "\n";

// Test creating snap token
try {
    $params = [
        'transaction_details' => [
            'order_id'     => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
        'item_details'        => [[
            'id'       => 'test',
            'price'    => 10000,
            'quantity' => 1,
            'name'     => 'Test Item',
        ]],
        'customer_details'    => [
            'first_name' => 'Test',
            'email'      => 'test@example.com',
        ],
    ];

    echo "Attempting to get Snap Token...\n";
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo "SUCCESS! Snap Token: " . $snapToken . "\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "\nPossible solutions:\n";
    echo "1. Get your Sandbox Server Key from: https://dashboard.sandbox.midtrans.com/settings/config_info\n";
    echo "2. Update application/config/midtrans.php with the correct key\n";
    echo "3. Make sure you're using SANDBOX key, not PRODUCTION key\n";
}

echo "</pre>";
