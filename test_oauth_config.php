<?php
/**
 * Test OAuth Configuration
 * 
 * Run: php test_oauth_config.php
 */

// Load .env file
if (file_exists(__DIR__.'/.env')) {
    $lines = file(__DIR__.'/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) continue;
        putenv(trim($line));
    }
}

echo "========================================\n";
echo "   OAuth Configuration Test\n";
echo "========================================\n\n";

$client_id = getenv('GOOGLE_CLIENT_ID');
$client_secret = getenv('GOOGLE_CLIENT_SECRET');

echo "✓ Checking .env file... ";
if (file_exists(__DIR__.'/.env')) {
    echo "FOUND\n";
} else {
    echo "NOT FOUND\n";
    echo "  → Create .env file in project root\n\n";
    exit(1);
}

echo "\n1. GOOGLE_CLIENT_ID:\n";
if ($client_id && $client_id !== '') {
    echo "   ✓ SET: " . substr($client_id, 0, 20) . "...\n";
    
    // Validate format
    if (strpos($client_id, '.apps.googleusercontent.com') !== false) {
        echo "   ✓ Format looks correct\n";
    } else {
        echo "   ⚠ Format might be incorrect (should end with .apps.googleusercontent.com)\n";
    }
} else {
    echo "   ✗ NOT SET or EMPTY\n";
    echo "   → Add to .env: GOOGLE_CLIENT_ID=your-id.apps.googleusercontent.com\n";
}

echo "\n2. GOOGLE_CLIENT_SECRET:\n";
if ($client_secret && $client_secret !== '') {
    echo "   ✓ SET: " . substr($client_secret, 0, 10) . "...\n";
    
    // Validate format
    if (strpos($client_secret, 'GOCSPX-') === 0 || strlen($client_secret) > 20) {
        echo "   ✓ Format looks correct\n";
    } else {
        echo "   ⚠ Format might be incorrect (usually starts with GOCSPX-)\n";
    }
} else {
    echo "   ✗ NOT SET or EMPTY\n";
    echo "   → Add to .env: GOOGLE_CLIENT_SECRET=your-secret\n";
}

echo "\n3. Composer Dependencies:\n";
if (file_exists(__DIR__.'/vendor/google/apiclient')) {
    echo "   ✓ Google API Client installed\n";
} else {
    echo "   ✗ Google API Client NOT installed\n";
    echo "   → Run: composer install\n";
}

echo "\n4. Database Schema:\n";
// Try to connect to database
define('BASEPATH', true);
define('ENVIRONMENT', 'development');

// Manually load database config
$db_file = __DIR__.'/application/config/database.php';
if (file_exists($db_file)) {
    include $db_file;
}

if (isset($db['default'])) {
    $db_cfg = $db['default'];
    $conn = @mysqli_connect($db_cfg['hostname'], $db_cfg['username'], $db_cfg['password'], $db_cfg['database']);
    
    if ($conn) {
        echo "   ✓ Database connection OK\n";
        
        // Check if oauth columns exist
        $result = mysqli_query($conn, "DESCRIBE user");
        $columns = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }
        
        $required = ['google_id', 'oauth_provider', 'avatar_url'];
        $missing = [];
        
        foreach ($required as $col) {
            if (in_array($col, $columns)) {
                echo "   ✓ Column '{$col}' exists\n";
            } else {
                echo "   ✗ Column '{$col}' MISSING\n";
                $missing[] = $col;
            }
        }
        
        if (!empty($missing)) {
            echo "\n   → Run migration: mysql -u root -p usahain_db < database/oauth_migration.sql\n";
        }
        
        mysqli_close($conn);
    } else {
        echo "   ✗ Cannot connect to database\n";
        echo "   → Check application/config/database.php\n";
    }
} else {
    echo "   ⚠ Cannot load database config\n";
}

echo "\n========================================\n";
echo "   Summary\n";
echo "========================================\n\n";

$all_ok = true;

if (!$client_id || $client_id === '') {
    echo "✗ Set GOOGLE_CLIENT_ID in .env\n";
    $all_ok = false;
}

if (!$client_secret || $client_secret === '') {
    echo "✗ Set GOOGLE_CLIENT_SECRET in .env\n";
    $all_ok = false;
}

if (!file_exists(__DIR__.'/vendor/google/apiclient')) {
    echo "✗ Run: composer install\n";
    $all_ok = false;
}

if ($all_ok) {
    echo "✓ Configuration looks good!\n";
    echo "\nNext steps:\n";
    echo "1. Restart Apache in XAMPP\n";
    echo "2. Go to: http://localhost/usahain/auth/login\n";
    echo "3. Click 'Lanjutkan dengan Google'\n";
    echo "\nGood luck! 🚀\n";
} else {
    echo "\n⚠ Please fix the issues above\n";
    echo "\nQuick Fix:\n";
    echo "1. Get credentials from: https://console.cloud.google.com\n";
    echo "2. Edit .env file\n";
    echo "3. Run: composer install\n";
    echo "4. Import: database/oauth_migration.sql\n";
    echo "\nSee: OAUTH_QUICKFIX.md for detailed guide\n";
}

echo "\n";
